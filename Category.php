<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    table{
        border:2px solid black;
    }
    tr,td{
        border:2px solid black;
    }
</style>
<body>
    <center>
        <h2>Category Page</h2>
        <form action="" method="POST" id="mypage">
            <table>
                <tr>
                    <td>
                       Category Name: <input type="text" name="name" id="name">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" value="submit" name="submit" id="submit">
                        <input type="reset" value="Reset">
                        <input type="hidden" name="id" id="id">
                        <input type="submit" value="update" id="updateID" name="updateID">
                    </td>
                </tr>
            </table>
        </form>
    </center>
    <center>
        <h2>Category Fetch:</h2>
        <table>
            <thead>
                <tr>
                    <td>ID:</td>
                    <td>Name:</td>
                    <td colspan="2">Operation</td>
                </tr>
            </thead>

            <tbody id="tabledata">

            </tbody>
        </table>
    </center>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"> </script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"> </script>  

    <script>

        $(document).ready(function(){
            category_fetch()
            showsubmitbutton()
        });

        $('#tabledata').on('click','.DeleteRecoard',function(){
            var id = $(this).attr('data-id');
            deleted(id)
        })

        $('#tabledata').on('click','.EditRecoard',function(){
            var id = $(this).attr('data-id');
            edited(id)
        });

        function showsubmitbutton()
        {
            $('#submit').show();
            $('#updateID').hide();
            $('#id').val('');
            $('#name').val('');
        }

        function showupdatebutton()
        {
            $('#submit').hide();
            $('#updateID').show();
        }
        function category_fetch()
        {
            $.ajax({
                method:'POST',
                url:'category_fetch.php',
                dataType:'json',
                success:function(data)
                {
                    var jsonData = JSON.stringify(data);
                    var resultdata = jQuery.parseJSON(jsonData);

                    if(resultdata.status == 1)
                    {
                        var table = '';
                        for(var i in resultdata.categorydata)
                        {
                            table += '<tr>';
                            table += '<td>'+resultdata.categorydata[i].id+'</td>';
                            table += '<td>'+resultdata.categorydata[i].name+'</td>';
                            table += '<td><a href="javascript:void(0)" class="EditRecoard" data-id="'+resultdata.categorydata[i].id+'">Edit</a></td>';
                            table += '<td><a href="javascript:void(0)" class="DeleteRecoard" data-id="'+resultdata.categorydata[i].id+'">Delete</a></td>';
                            table += '</tr>';
                        }
                        $('#tabledata').html(table);
                    }
                }
            });
        }

        function deleted(id)
        {
            $.ajax({
                method:'POST',
                url:'category_delete.php',
                data:{id:id},
                dataType:'json',
                success:function(data)
                {
                    var jsonData = JSON.stringify(data);
                    var resultdata = jQuery.parseJSON(jsonData);

                    if(resultdata.status == 1)
                    {
                        alert(resultdata.message)
                        category_fetch();
                    }
                    else
                    {
                        alert(resultdata.message)
                    }
                }
            });
        }

        function edited(id)
        {
            $.ajax({
                method:'POST',
                url:'category_edit.php',
                data:{id:id},
                dataType:'json',
               
                success:function(data)
                {
                    var jsonData = JSON.stringify(data);
                    var resultdata = jQuery.parseJSON(jsonData);

                    if(resultdata.status == 1)
                    {
                        $('#id').val(id);
                        $('#name').val(resultdata.name);
                        showupdatebutton()
                    }
                    else
                    {
                        alert(resultdata.message)
                    }
                }
            })
        }

        $('#mypage').validate({
            rules:{
                name:{
                    required:true
                }
            },
            messages:{
                name:{
                    required:"This field is required"
                }
            },

            submitHandler:function(form){
                

                var url;
                if($('#id').val()== '')
                {
                    url = "category_insert.php";
                }
                else
                {
                    url = "category_update.php";
                }
                alert("Submit");
                var formdata = new FormData(form);
                $.ajax({
                    method:"POST",
                    url:url,
                    data:formdata,
                    processData:false,
                    contentType:false,
                    dataType:'json',
                    success:function(data)
                    {
                        var jsonData = JSON.stringify(data);
                        var resultdata = jQuery.parseJSON(jsonData);

                        if(resultdata.status == 1)
                        {
                            alert(resultdata.message);
                            category_fetch()
                            showsubmitbutton()
                        }
                        else
                        {
                            alert(resultdata.message);
                        }
                    }
                })
            }
        });

    </script>
</body>
</html>