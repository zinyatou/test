//index.php
<!doctype html>
<head>
    <title>TEST TECHNIQUE</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
</head>
<body>
<div class="container">
    <br />
    <h3 position="center">CARNET DE CONTACT</h3>   
    <br />
    <div position="right">
        <button type="button" id="add_button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal">
          Ajouter
        </button>
    </div>
    <br />    
    <table id="member_table" class="table table-striped">  
        <thead class="bg-primary text-white">
    <tr>
        <th width="30%">ID</th>
        <th width="50%">FULL Name</th>  
        <th width="30%">CATEGORIES</th>
        <th scope="col" width="5%">Edit</th>
        <th scope="col" width="5%">FERMER</th>
    </tr>
</thead>

    </table>
     
    <div class="modal" id="userModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Ajouter</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
          </div>
          <div class="modal-body">
            <form method="post" id="member_form" enctype="multipart/form-data">
                <div class="modal-body">
                    <label>saisir nom et prénom</label>
                    <input type="text" name="name" id="name" class="form-control" />
                    <br />
                    <label>votre catégorie</label>
                    <br /> 
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="member_id" id="member_id" />
                    <input type="hidden" name="operation" id="operation" />
                    <input type="submit" name="action" id="action" class="btn btn-primary" value="Add" />
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>  
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" >
$(document).ready(function(){
    $('#add_button').click(function(){
        $('#member_form')[0].reset();
        $('.modal-title').text("Add New Details");
        $('#action').val("Add");
        $('#operation').val("Add");
    });
     
    var dataTable = $('#member_table').DataTable({
        "paging":true,
        "processing":true,
        "serverSide":true,
        "order": [],
        "info":true,
        "ajax":{
            url:"fetch.php",
            type:"POST"
               },
        "columnDefs":[
            {
                "targets":[0,3,4],
                "orderable":false,
            },
        ],    
    });
 
    $(document).on('submit', '#member_form', function(event){
        event.preventDefault();
        var id = $('#id').val();
        var name = $('#name').val();
        var category = $('#category').val();
         
        if(name != '' && category != '')
        {
            $.ajax({
                url:"insertupdated.php",
                method:'POST',
                data:new FormData(this),
                contentType:false,
                processData:false,
                success:function(data)
                {
                    $('#member_form')[0].reset();
                    $('#userModal').modal('hide');
                    dataTable.ajax.reload();
                }
            });
        }
        else
        {
            alert("Name, category Fields are Required");
        }
    });
     
    $(document).on('click', '.update', function(){
        var member_id = $(this).attr("id");
        $.ajax({
            url:"fetch_single.php",
            method:"POST",
            data:{member_id:member_id},
            dataType:"json",
            success:function(data)
            {
                $('#userModal').modal('show');
                $('#id').val(data.id);
                $('#name').val(data.fullname);
                $('#category').val(data.category);
                $('.modal-title').text("Edit Member Details");
                $('#member_id').val(member_id);
                $('#action').val("Save");
                $('#operation').val("Edit");
            }
        })
    });
     
    $(document).on('click', '.delete', function(){
        var member_id = $(this).attr("id");
        if(confirm("Are you sure you want to delete this user?"))
        {
            $.ajax({
                url:"delete.php",
                method:"POST",
                data:{member_id:member_id},
                success:function(data)
                {
                    dataTable.ajax.reload();
                }
            });
        }
        else
        {
            return false;   
        }
    });
     
     
});
</script>             
</body>
</html>




