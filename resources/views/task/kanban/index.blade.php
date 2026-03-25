@extends('layout')

@section('main')
    <div id="myKanban" class="kanban"></div>
    <button id="addDefault">Add "Default" board</button>
    <br />
    <button id="addToDo">Add element in "To Do" Board</button>
    <br />
    <button id="addToDoAtPosition">Add element in "To Do" Board at position 2</button>
    <br />
    <button id="removeBoard">Remove "Done" Board</button>
    <br />
    <button id="removeElement">Remove "My Task Test"</button>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/jkanban@1.3.1/dist/jkanban.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/jkanban@1.3.1/dist/jkanban.min.css" rel="stylesheet">

    <script>
      var KanbanTest = new jKanban({
        element: "#myKanban",
        gutter: "10px",
        widthBoard: "250px",
        //itemHandleOptions:{
        //  enabled: true,
        //},
        click: function(el) {
          console.log("Trigger on all items click!");
        },
        context: function(el, e) {
          console.log("Trigger on all items right-click!");
        },
        dropEl: function(el, target, source, sibling){
          console.log(target.parentElement.getAttribute('data-id'));
          console.log(el, target, source, sibling)
        },
        /*
        buttonClick: function(el, boardId) {
          console.log(el);
          console.log(boardId);
          // create a form to enter element
          var formItem = document.createElement("form");
          formItem.setAttribute("class", "itemform");
          formItem.innerHTML =
            '<div class="form-group"><textarea class="form-control" rows="2" autofocus></textarea></div><div class="form-group"><button type="submit" class="btn btn-primary btn-xs pull-right">Submit</button><button type="button" id="CancelBtn" class="btn btn-default btn-xs pull-right">Cancel</button></div>';

          KanbanTest.addForm(boardId, formItem);
          formItem.addEventListener("submit", function(e) {
            e.preventDefault();
            var text = e.target[0].value;
            KanbanTest.addElement(boardId, {
              title: text
            });
            formItem.parentNode.removeChild(formItem);
          });
          document.getElementById("CancelBtn").onclick = function() {
            formItem.parentNode.removeChild(formItem);
          };
        },
        itemAddOptions: {
          enabled: true,
          content: '+ Add New Card',
          class: 'custom-button',
          footer: true
        },
        */
        dragBoards : false, 
        boards: [
          {
            id: "_TOSTART",
            title: "Sin empezar",
            class: "info,good",
            //dragTo: ["_working"],
            item: [
              {
                id: "_TOSTART",
                title: "Sin empezar <div><em>test</em></div> <button class='btn btn-primary'> TEST </button>",
                drag: function(el, source) {
                  console.log("START DRAG: " + el.dataset.eid);
                },
                dragend: function(el) {
                  console.log("END DRAG: " + el.dataset.eid);
                },
                drop: function(el) {
                  console.log("DROPPED: " + el.dataset.eid);
                }
              },
              {
                title: "Try Click This!",
                click: function(el) {
                  alert("click");
                },
                context: function(el, e){
                  alert("right-click at (" + `${e.pageX}` + "," + `${e.pageX}` + ")")
                },
                class: ["peppe", "bello"]
              }
            ]
          },
          {
            id: "_PROCESS",
            title: "En proceso",
            class: "warning",
            item: [
              {
                title: "Do Something!"
              },
              {
                title: "Run?"
              }
            ]
          },
          {
            id: "_FINALIZED",
            title: "Finalizado",
            class: "success",
            //dragTo: ["_working"],
            item: [
              {
                title: "All right"
              },
              {
                title: "Ok!"
              }
            ]
          },
          {
            id: "_DELAY",
            title: "Retrasado",
            class: "success",
            //dragTo: ["_working"],
            item: [
              {
                title: "<b>All</b> right"
              },
              {
                title: "Ok!"
              }
            ]
          },
          {
            id: "_PAUSED",
            title: "Pausado",
            class: "success",
            //dragTo: ["_working"],
            item: [
              {
                title: "All right"
              },
              {
                title: "Ok!"
              }
            ]
          }
        ]
      });

      var toDoButton = document.getElementById("addToDo");
      toDoButton.addEventListener("click", function() {
        KanbanTest.addElement("_todo", {
          title: "Test Add"
        });
      });

      var toDoButtonAtPosition = document.getElementById("addToDoAtPosition");
      toDoButtonAtPosition.addEventListener("click", function() {
        KanbanTest.addElement("_todo", {
          title: "Test Add at Pos"
        }, 1);
      });

      var addBoardDefault = document.getElementById("addDefault");
      addBoardDefault.addEventListener("click", function() {
        KanbanTest.addBoards([
          {
            id: "_default",
            title: "Kanban Default",
            item: [
              {
                title: "Default Item"
              },
              {
                title: "Default Item 2"
              },
              {
                title: "Default Item 3"
              }
            ]
          }
        ]);
      });

      var removeBoard = document.getElementById("removeBoard");
      removeBoard.addEventListener("click", function() {
        KanbanTest.removeBoard("_done");
      });

      var removeElement = document.getElementById("removeElement");
      removeElement.addEventListener("click", function() {
        KanbanTest.removeElement("_test_delete");
      });

      var allEle = KanbanTest.getBoardElements("_todo");
      allEle.forEach(function(item, index) {
        //console.log(item);
      });
    </script>
@endsection