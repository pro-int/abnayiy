/*=========================================================================================
    File Name: ext-component-drag-drop.js
    Description: drag & drop elements using dragula js
    --------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/
/*=========================================================================================
    File Name: ext-component-drag-drop.js
    Description: drag & drop elements using dragula js
    --------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(function () {
  'use strict';

  let studentCount = document.getElementById('studentCount')
  let studentNotInClassCount = document.getElementById('studentNotInClassCount')

  let classStudents = document.getElementById('multiple-list-group-a')
  let NoneClassStudents = document.getElementById('multiple-list-group-b')


  dragula([classStudents, NoneClassStudents])
    .on('drop', function (el, target) {
      if (target.id == NoneClassStudents.id) {
        el.className = el.className.replace('bg-light-warning', '');
      } else {
        el.className += ' bg-light-warning';
      }
    }).on('out', function () {
      UpdateStudentsCount()
    });

  function UpdateStudentsCount() {
    studentCount.textContent = classStudents.getElementsByTagName('input').length
    studentNotInClassCount.textContent = NoneClassStudents.getElementsByTagName('input').length
  }


});
