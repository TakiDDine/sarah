/*jslint browser: true, devel: true, white: true, eqeq: true, plusplus: true, sloppy: true, vars: true*/
/*global $ */

/*************** General ***************/

var updateOutput = function (e) {
  var list = e.length ? e : $(e.target),
      output = list.data('output');
  if (window.JSON) {
    if (output) {
      output.val(window.JSON.stringify(list.nestable('serialize')));
    }
  } else {
    alert('JSON browser support required for this page.');
  }
};

var nestableList = $(".dd.nestable > .dd-list");

/***************************************/


/*************** Delete ***************/

var deleteFromMenuHelper = function (target) {
  
    // if it's not yet saved in the database, just remove it from DOM
    target.fadeOut(function () {
      target.remove();
      updateOutput($('.dd.nestable').data('output', $('#json-output')));
    });
  
};

var deleteFromMenu = function () {
  var targetId = $(this).data('owner-id');
  var target = $('[data-id="' + targetId + '"]');

  var result = confirm("Delete " + target.data('name') + " and all its subitems ?");
  if (!result) {
    return;
  }

  // Remove children (if any)
  target.find("li").each(function () {
    deleteFromMenuHelper($(this));
  });

  // Remove parent
  deleteFromMenuHelper(target);

  // update JSON
  updateOutput($('.dd.nestable').data('output', $('#json-output')));
};

/***************************************/


/*************** Edit ***************/

var menuEditor = $("#menu-editor");
var editButton = $("#editButton");
var editInputName = $("#editInputName");
var editInputSlug = $("#editInputSlug");
var currentEditName = $("#currentEditName");

// Prepares and shows the Edit Form
var prepareEdit = function () {
  var targetId = $(this).data('owner-id');
  var target = $('[data-id="' + targetId + '"]');

  editInputName.val(target.data("name"));
  editInputSlug.val(target.data("slug"));
  currentEditName.html(target.data("name"));
  editButton.data("owner-id", target.data("id"));

  console.log("[INFO] Editing Menu Item " + editButton.data("owner-id"));

  menuEditor.fadeIn();
};

// Edits the Menu item and hides the Edit Form
var editMenuItem = function () {
  var targetId = $(this).data('owner-id');
  var target = $('[data-id="' + targetId + '"]');

  var newName = editInputName.val();
  var newSlug = editInputSlug.val();

  target.data("name", newName);
  target.data("slug", newSlug);

  target.find("> .dd-handle").html(newName);

  menuEditor.fadeOut();

  // update JSON
  updateOutput($('.dd.nestable').data('output', $('#json-output')));
};

/***************************************/


/*************** Add ***************/

var newIdCount = 1;

var addToMenu = function () {
  var newName = $("#addInputName").val();
  var newSlug = $("#addInputSlug").val();
  var newId = 'new-' + newIdCount;

  nestableList.append(
    '<li class="dd-item" ' +
    'data-id="' + newId + '" ' +
    'data-name="' + newName + '" ' +
    'data-slug="' + newSlug + '" ' +
    'data-new="1" ' +
    '>' +
    '<div class="dd-handle">' + newName + '</div> ' +
    '<span class="button-delete btn btn-default btn-xs pull-right" ' +
    'data-owner-id="' + newId + '"> ' +
    '<i class="icon-cross3"></i> ' +
    '</span>' +
    '<span class="button-edit btn btn-default btn-xs pull-right" ' +
    'data-owner-id="' + newId + '"  data-toggle="modal" data-target="#edit_modal">' +
    '<i class="icon-pencil7"></i>' +
    '</span>' +
    '</li>'
  );

  newIdCount++;

  // update JSON
  updateOutput($('.dd.nestable').data('output', $('#json-output')));

  // set events
  $(".dd.nestable .button-delete").on("click", deleteFromMenu);
  $(".dd.nestable .button-edit").on("click", prepareEdit);
};



/***************************************/


var addPageToMenu = function () {
    
var checks = document.getElementsByClassName('styled');
                var str = '';
                 
                for ( i = 0; i < 10; i++) {
                     
                    if ( checks[i].checked === true ) {
                        
                          var newName = checks[i].dataset.name;
                          var newSlug = checks[i].dataset.slug;
                          var newId = 'new-' + newIdCount;

                          nestableList.append(
                            '<li class="dd-item" ' +
                            'data-id="' + newId + '" ' +
                            'data-name="' + newName + '" ' +
                            'data-slug="' + newSlug + '" ' +
                            '' +
                            '>' +
                            '<div class="dd-handle">' + newName + '</div> ' +
                            '<span class="button-delete btn btn-default btn-xs pull-right" ' +
                            'data-owner-id="' + newId + '"> ' +
                            '<i class="icon-cross3"></i> ' +
                            '</span>' +
                            '<span class="button-edit btn btn-default btn-xs pull-right" ' +
                            'data-owner-id="' + newId + '" data-toggle="modal" data-target="#edit_modal">' +
                            '<i class="icon-pencil7"></i>' +
                            '</span>' +
                            '</li>'
                          );

                          newIdCount++;

                          // update JSON
                          updateOutput($('.dd.nestable').data('output', $('#json-output')));

                          // set events
                          $(".dd.nestable .button-delete").on("click", deleteFromMenu);
                          $(".dd.nestable .button-edit").on("click", prepareEdit);       
                        
                
                    }
                     
                }

    
    
};



$(function () {

  // output initial serialised data
  updateOutput($('.dd.nestable').data('output', $('#json-output')));

  // set onclick events
  editButton.on("click", editMenuItem);

  $(".dd.nestable .button-delete").on("click", deleteFromMenu);

  $(".dd.nestable .button-edit").on("click", prepareEdit);

  $("#menu-editor").submit(function (e) {
    e.preventDefault();
  });

  $("#menu-add").submit(function (e) {
    e.preventDefault();
    addToMenu();
  });
    
    // jjdd
    $("#menu-add-pages").submit(function (e) {
        e.preventDefault();
        addPageToMenu();
    }); 

});

