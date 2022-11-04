<?php

namespace Gtech\AbnayiyNotification\Controllers\admin;

use App\Http\Controllers\Controller;
use Gtech\AbnayiyNotification\Models\NotificationSection;
use Illuminate\Http\Request;

class AdminNotificationSectionsController extends Controller
{
    public function index()
    {
        
        $sections = NotificationSection::orderBy('id')->get();

        return view('Notification::Notifications.Sections.index', compact('sections'));
    }

    public function edit(NotificationSection $section)
    {
        return view('Notification::Notifications.Sections.edit', compact('section'));

    }

    public function update(Request $request, NotificationSection $section)
    {
        $section->section_name = $request->section_name;
        
        if ($section->save()) {
            return redirect()->route('sections.index')
                ->with('alert-success', 'تم تعديل القسم بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء تعديل القسم');
    }

}