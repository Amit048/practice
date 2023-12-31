<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SubCategory</title>
</head>
<style>
    table{
        border:2px solid black;
    }
    tr,td{
        border:2px solid black;
    }
    label.error{
        color:#f00;
    }
</style>
<body>
    <center>
        <h2>SubCategory</h2>
        <form action="" method="POST" id="myform">
            <table>
                <tr>
                    <td>
                       Category:<select name="catid" id="catid">
                        <option value="">Select CatName</option>
                       </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        SubcatName:<input type="text" name="subcatname" id="subcatname">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" value="submit" name="submit" id="submit">
                        <input type="reset" value="Reset">
                        <input type="hidden" name="id" id="id">
                        <input type="submit" value="Update" name="updateId" id="updateId">
                    </td>
                </tr>
            </table>
        </form>
    </center>

    <center>
        <h2>SubCategory Fetch:</h2>
        <table>
            <thead>
                <tr>
                    <td>ID:</td>
                    <td>Category</td>
                    <td>SubCategory</td>
                    <td colspan="2">Operations</td>
                </tr>
            </thead>
            <tbody id="tablebody">

            </tbody>
        </table>
    </center>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"> </script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"> </script> 

    <script>

        $(document).ready(function(){
            category()
            subcategory();
            showsubmitbutton()
        });

        $('#tablebody').on('click','.DeleteRecoard',function(){
            var id = $(this).attr('data-id');
            deleted(id);
        });

        $('#tablebody').on('click','.EditRecoard',function(){
            var id = $(this).attr('data-id');
            edited(id);
        });

       function showsubmitbutton()
        {
            $('#submit').show();
            $('#updateId').hide();
            $('#id').val('');
            $('#catid').val('');
            $('#subcatname').val('');
        }

        function showupdatebutton()
        {
            $('#submit').hide();
            $('#updateId').show();
        }

        function category()
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
                        table += '<option value = "">Select CatName</option>';
                        for(var i in resultdata.categorydata)
                        {
                            table += '<option value="'+resultdata.categorydata[i].id+'">'+resultdata.categorydata[i].name+'</option>'
                        }
                        $('#catid').html(table)
                    }
                }
            });
        }

        function subcategory()
        {
            $.ajax({
                method:'POST',
                url:'SubCategory_Fetch.php',
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
                            table += '<td>'+resultdata.categorydata[i].catid+'</td>';
                            table += '<td>'+resultdata.categorydata[i].subcatname+'</td>';
                            table += '<td><a href="javascript:void(0)" class="EditRecoard" data-id="'+resultdata.categorydata[i].id+'">Edit</a></td>';
                            table += '<td><a href="javascript:void(0)" class="DeleteRecoard" data-id="'+resultdata.categorydata[i].id+'">Delete</a></td>';
                            table += '</tr>';
                        }
                        $('#tablebody').html(table)
                    }
                    else
                    {
                        alert(resultdata.message);
                    }
                }
            })
        }

        function deleted(id)
        {
            $.ajax({
                method:'POST',
                url:'SubCategory_Delete.php',
                dataType:'json',
                data:{id:id},
                success:function(data)
                {
                    var jsonData = JSON.stringify(data);
                    var resultdata = jQuery.parseJSON(jsonData);

                    if(resultdata.status == 1)
                    {
                        alert(resultdata.message);
                        subcategory()
                    }
                    else
                    {
                        alert(resultdata.message);
                    }
                }
            })
        }

        function edited(id)
        {
            $.ajax({
                method:'POST',
                url:'SubCategory_Edit.php',
                dataType:'json',
                data:{id:id},
                success:function(data)
                {
                    var jsonData = JSON.stringify(data);
                    var resultdata = jQuery.parseJSON(jsonData);

                    if(resultdata.status == 1)
                    {
                        $('#id').val(id);
                        $('#catid').val(resultdata.catid);
                        $('#subcatname').val(resultdata.subcatname);
                        showupdatebutton()
                    }
                    else
                    {
                        alert(resultdata.message);
                    }
                }
            })
        }

        $('#myform').validate({
            rules:{
                catid:{
                    required:true
                },
                subcatname:{
                    required:true
                }
            },

            messages:{
                catid:{
                    required:"Please select category!"
                },
                subcatname:{
                    required:"This field is required!"
                }
            },
            submitHandler:function(form)
            {
                if($('#id').val()== '')
                {
                    url = "subcategory_insert.php";
                }
                else
                {
                    url = "subcategory_update.php";
                }

                alert("submit");

                var formdata = new FormData(form);
                $.ajax({
                    method:'POST',
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
                            subcategory()
                            showsubmitbutton()
                        }
                        else
                        {
                            alert(resultdata.message);
                        }
                    }
                })
            }
        })
    </script>
</body>
</html>