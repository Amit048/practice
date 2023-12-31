<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<style>

    h2 {
        color: green;
    }

    label {
        display: inline-block;
        width: 150px;
    }

    table
    {
        border: 2px solid black;
    }
        
    tr,td,th
    {
         border: 2px solid black;
    }
    label.error{
        color:#f00;
    }
    #popupBox {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: white;
    padding: 20px;
    border: 2px solid black;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    z-index: 999;
}
        
</style>

<body>
    <center>
        <h2>Purchase Master:</h2><hr>

        <form action="" method="POST" id="myform">

            <label for="purchasename">Purchase Name</label><br>
            <input type="text" name="purchasename" id="purchasename">
        
            <br><br>
            <h2>Details:</h2>
    
            <label for="Category">Category</label>
            <select id="catid" name="catid">
            <option value="" selected>Select Category</option>
            </select>

            <label for="Subcategory">Subcategory</label>
            <select id="subcatid" name="subcatid">
            <option value="" selected>Select SubCategory</option>
            </select> 

            <label for="Item">Item</label>
            <select id="itemid" name="itemid">
            <option value="" selected>Select Item</option>
            </select>

            <label for="Item Amount">Item Amount</label>
            <input type="text" id="itemamount" name="itemamount">

            <label for="Quantity:">Quantity:</label>
            <input type="text" name="quantity" id="quantity">

            <button type="button" id="addData" name="addData" >Add</button>

            
            <h2>Grid Recoard</h2>
            <table>
                <thead>
                    <tr>
                        
                        <th>Category</th>
                        <th>Subcategory</th>
                        <th>Item</th>
                        <th>Item Amount</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                
                <tbody id="gridBody">            

                </tbody>
            </table>
            <br><br>
            <input type="submit" value="Submit" name="submit" id="submit"><br><br><br>
            <input type="hidden" name="purchaseid" id="purchaseid">
           <input type="submit" value="update" id="updateId" name="updateId">
           <input type="hidden" name="action" id="action">
        </form>
    </center>


    <div class="container mt-2">
        <h2>Fetching Purchase Name:</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Purchase Name</th>
                    <th colspan="2">Actions:</th>
                </tr>
            </thead>
            <tbody id="purchaseBody">
                
            </tbody>
        </table>
    </div>

    <div class="container mt-4">
        <div id="popupBox">
            <h2>Purchase Master Details<span id="popupPurchaseName"></span></h2>
            <table id="popupTable" class="table">
            </table>
            <button onclick="closepopup()" class="btn btn-primary">Close</button>
        </div>
    </div>

    <div class="modal fade" id="purchaseDetailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="purchaseDetailsModalLabel">Purchase Details</h5>
                </div>
                <div class="modal-body">
                    <table id="modalPopupTable" class="table">
                    </table>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                 <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    </center>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <script>

        //category fetch function... 
        $(document).ready(function(){
            category();
            purchase_master_fetch()
            showsubmitbutton()
            setAction()
        });
        

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
                        table += '<option value = "">Select Category</option>';
                        for(var i in resultdata.categorydata)
                        {
                            table += '<option value = "'+resultdata.categorydata[i].id+'">'+resultdata.categorydata[i].name+'</option>';
                        }
                        $('#catid').html(table);
                        subcategory()
                    }
                }
            });
        }

        
        $('#catid').change(function(){
            subcategory();
        });

        //subcategory fetch function
        function subcategory()
        {
            var catid = $('#catid').val();
            $.ajax({
                method:'POST',
                url:'SubCategory_Fetch.php',
                dataType:'json',
                data:{catid:catid,flag:1},
                success:function(data)
                {
                    var jsonData = JSON.stringify(data);
                    var resultdata = jQuery.parseJSON(jsonData);

                    if(resultdata.status == 1)
                    {
                        var table = '';
                        table += '<option value = "">Select SubCategory</option>';
                        for(var i in resultdata.categorydata)
                        {
                            table += '<option value = "'+resultdata.categorydata[i].id+'">'+resultdata.categorydata[i].subcatname+'</option>';
                            
                        }
                        $('#subcatid').html(table);
                        ItemMaster();
                    }
                }
            });
        }

        
        $('#subcatid').change(function(){
            ItemMaster();
        });


        //this is change event function for itemid to itemamount
        $('#itemid').change(function () {
        var selectitem = $('#itemid option:selected');
        var itemamount = selectitem.attr('itemamount');
        $('#itemamount').val(itemamount);
        });

    
        //item master fetch table
        function ItemMaster()
        {
            var subcatid = $('#subcatid').val();
            $.ajax({
                method:'POST',
                url:'item_fetch.php',
                dataType:'json',
                data:{subcatid:subcatid,formPurchaseItemMaster:1},
                success:function(data)
                {
                    var jsonData = JSON.stringify(data);
                    var resultdata = jQuery.parseJSON(jsonData);

                    if(resultdata.status == 1)
                    {
                        var table = '';
                        table += '<option value = "">Select ItemMatser</option>';
                        for(var i in resultdata.categorydata)
                        {
                            table += '<option value="' + resultdata.categorydata[i].id + '" itemamount="' + resultdata.categorydata[i].itemamount + '">' + resultdata.categorydata[i].itemname + '</option>';
                        }
                        $('#itemid').html(table);
                    }
                }
            });
        }

    
        //data stroing in grid view
        $('#addData').click(function(){
            var catid = $('#catid').val();
            var catname = $('#catid option:selected').text();
            var subcatid = $('#subcatid').val();
            var subcatname = $('#subcatid option:selected').text();
            var itemid = $('#itemid').val();
            var item = $('#itemid option:selected').text();
            var itemamount = $('#itemamount').val();
            var quantity = $('#quantity').val();

            
            if(!catid || !subcatid || !itemid || !itemamount || !quantity)
            {
                alert("please fill in all the required fields!");
                
            }
            else
            {

            var table = '';
            table += '<tr>';
            table += '<td><input type="hidden" id="tblcatid" name="tblcatid[]" value="'+catid+'"><input type="hidden" id="tblcatname" name="tblcatname[]" value="'+catname+'">' + catname+'</td>';

            table += '<td><input type="hidden" id="tblsubcatid" name="tblsubcatid[]" value="'+subcatid+'"><input type="hidden" id="tblsubcatname" name="tblsubcatname[]" value="'+subcatname+'">' + subcatname+'</td>';

            table += '<td><input type="hidden" id="tblitemid" name="tblitemid[]" value="'+itemid+'"><input type="hidden" id="tblitemname" name="tblitemname[]" value="'+item+'">' + item+'</td>';

            table += '<td><input type="hidden" id="tblitemamount" name="tblitemamount[]" value="'+itemamount+'">' + itemamount + '</td>';
            table += '<td><input type="hidden" id="tblquantity" name="tblquantity[]" value="'+quantity+'">' + quantity + '</td>';
            table += '<td><button class="removeRow" onclick="removeRow(this)">❎</button></td>'
            table += '</tr>';
            
            $('#gridBody').append(table);

            $('#catid').val('');
            $('#subcatid').val('');
            $('#itemid').val('');
            $('#itemamount').val('');
            $('#quantity').val('');
            }
        
        });
       
        function removeRow(button)
        {
            $(button).closest('tr').remove();
        }

        $('#purchaseBody').on('click','.showRecord',function(){
        //var purchaseid = $(this).attr('data-id');
        var purchasename = $(this).data("id");
        //var purchaseid = $(this).text();
        console.log("Purchase ID: " + purchasename);
        purchase_details_fetch(purchasename)
        });

        function closepopup() {
        $('#popupBox').hide();
        }


        function purchase_master_fetch()
        {

            $.ajax({
                method:'POST',
                url:'purchase_master_fetch2.php',
                dataType:'json',
                //data:{purchaseid:purchaseid},
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
                            table += '<td><a class="showRecord" data-id="' + resultdata.categorydata[i].id + '">'+resultdata.categorydata[i].purchasename+'</td>';
                            table += '<td><a href="javascript:void(0)" class="editRecoard" data-id="' + resultdata.categorydata[i].id + '" >Edit</a></td>';
                            table += '<td><a href="javascript:void(0)" class="deleteRecoard" data-id="' + resultdata.categorydata[i].id + '">Delete</a></td>';
                            table +='</tr>';
                        }
                        $('#purchaseBody').html(table);
                    }
                    
                }
            });
        }

        function purchase_details_fetch(purchaseid)
        {

            $.ajax({
                method:'POST',
                url:'purchase_details_fetch2.php',
                data: {purchaseid: purchaseid},
                dataType: 'json',
                success:function(data)
                {
                    var jsonData = JSON.stringify(data);
                    var resultdata = jQuery.parseJSON(jsonData);

                    if(resultdata.status == 1)
                    {
                        var table = '';
                        table += '<thead><tr><th>Category</th><th>Subcategory</th><th>Item</th><th>Item Amount</th><th>Quantity</th></tr></thead>';
                        for(var i in resultdata.categorydata)
                        {
                            table += '<tr>';
                            table += '<td>'+resultdata.categorydata[i].catid+'</td>'
                            table += '<td>'+resultdata.categorydata[i].subcatid+'</td>'
                            table += '<td>'+resultdata.categorydata[i].itemid+'</td>'
                            table += '<td>'+resultdata.categorydata[i].itemamount+'</td>'
                            table += '<td>'+resultdata.categorydata[i].quantity+'</td>'
                            table +='</tr>';
                        }
                        $('#popupTable').html(table);
                        $('#popupBox').show();
                        //$('#popupPurchaseName').text(resultdata.purchasename);
                    }
                    else
                    {
                        alert(resultdata.message);
                    }
                }
            });
        }

        $('#purchaseBody').on('click','.deleteRecoard',function(){
            var purchaseid = $(this).attr('data-id');
            purchase_delete(purchaseid)
        });

        function purchase_delete(purchaseid)
        {
            $.ajax({
                method:'POST',
                url:'Purchase_delete2.php',
                dataType:'json',
                data:{purchaseid:purchaseid},
                success:function(data)
                {
                    var jsonData = JSON.stringify(data);
                    var resultdata = jQuery.parseJSON(jsonData);

                    if(resultdata.status == 1)
                    {
                        alert(resultdata.message);
                        purchase_master_fetch()
                    }
                    else
                    {
                        alert(resultdata.message);
                    }
                }
            });
        }

        function showsubmitbutton()
        {
            $('#submit').show();
            $('#updateId').hide();
            $('#id').val('');
            $('#purchasename').val('');
            $('#purchaseid').val('');
            $('#catid').val('');
            $('#catname').val('');
            $('#subcatid').val('');
            $('#subcatname').val('');
            $('#itemid').val('');
            $('#itemname').val('');
            $('#itemamount').val('');
            $('#quantity').val('');
        }

        function showupdatebutton()
        {
            $('#submit').hide();
            $('#updateId').show();
        }
        function setAction() {
        $('#action').val();
        }

        $('#purchaseBody').on('click', '.editRecoard', function () {
        var purchaseid = $(this).data("id");
        $('#purchaseid').val(purchaseid);
        purchase_edit(purchaseid);
        });

       
        
        function purchase_edit(purchaseid) 
        {
            $.ajax({
                method: 'POST',
                url: 'purchase_edit2.php',
                dataType: 'json',
                data: { purchaseid: purchaseid },
                success: function (data) 
                {
                    var jsonData = JSON.stringify(data);
                    var resultdata = jQuery.parseJSON(jsonData);

                    if (resultdata.status == 1) 
                    {
                            var table = '';
                            for (var i in resultdata.categorydata) 
                                    {
        
                                        var tblcatid = resultdata.categorydata[i].catid;
                                        var tblcatname = resultdata.categorydata[i].catname;
                                        var tblsubcatid = resultdata.categorydata[i].subcatid;
                                        var tblsubcatname = resultdata.categorydata[i].subcatname;
                                        var tblitemid = resultdata.categorydata[i].itemid;
                                        var tblitemname = resultdata.categorydata[i].itemname;
                                        var tblitemamount = resultdata.categorydata[i].itemamount;
                                        var tblquantity = resultdata.categorydata[i].quantity;


                                        table += '<tr>';
                                        table += '<td><input type="hidden" id="tblcatid" name="tblcatid[]" value="'+tblcatid+'"><input type="hidden" id="tblcatname" name="tblcatname[]" value="'+tblcatname+'">' + tblcatname + '</td>';

                                        table += '<td><input type="hidden" id="tblsubcatid" name="tblsubcatid[]" value="'+tblsubcatid+'"><input type="hidden" id="tblsubcatname" name="tblsubcatname[]" value="'+tblsubcatname+'">' + tblsubcatname + '</td>';

                                        table += '<td><input type="hidden" id="tblitemid" name="tblitemid[]" value="'+tblitemid+'"><input type="hidden" id="tblitemname" name="tblitemname[]" value="'+tblitemname+'">' + tblitemname + '</td>';

                                        table += '<td><input type="hidden" id="tblitemamount" name="tblitemamount[]" value="'+tblitemamount+'">' + tblitemamount + '</td>';
                                        table += '<td><input type="hidden" id="tblquantity" name="tblquantity[]" value="'+tblquantity+'">' + tblquantity + '</td>';
                                        table += '<td><button class="removeRow" onclick="removeRow(this)">❎</button></td>'
                                        table += '</tr>';

                                    }

                                    $('#gridBody').html(table);
                                    $('#id').val(resultdata.id);
                                    $('#purchasename').val(resultdata.purchasename);
                                    $('#catid').val(resultdata.catid);
                                    $('#subcatid').val(resultdata.subcatid);
                                    $('#itemid').val(resultdata.itemid);
                                    $('#itemamount').val(resultdata.itemamount);
                                    $('#quantity').val(resultdata.quantity);        
                                    showupdatebutton()
                                }
                            }
                        });
                    }


                /*function setAction() {
                    var action = $('#action').val();
                    if(action == 'updateId')
                    {
                        var url = 'purchase_update.php';
                    }
                    else if(action == 'submit')
                    {
                        var url = 'purchase_insert.php';
                    }
                    else
                    {
                        url = 'Purchase_delete.php';
                    }
                }*/
        
        $('#myform').validate({
            rules:{
                purchasename:{
                    required : true
                }
            },
            messages:{
                purchasename:{
                    required:"Purchase Name field is required!"
                }
            },

            submitHandler:function(form) 
            {
                var gridRowCount = $('#gridBody tr').length;
                if (!gridRowCount) 
                {
                    alert("Please fill all the data!");
                }
                else
                {
 
                    
                    if ($('#purchaseid').val() == '') 
                    {
                        var url = 'purchase_insert.php';
                    }
                    else
                    {
                       var url = 'purchase_update2.php';
                    }
                        var formdata = new FormData(form)
                        $.ajax({
                            method:'POST',
                            url:url,
                            dataType:'json',
                            data:formdata,
                            processData:false,
                            contentType:false,
                            success:function(data)
                            {
                                var jsonData = JSON.stringify(data);
                                var resultdata = jQuery.parseJSON(jsonData);

                                if(resultdata.status == 1)
                                {
                                    alert(resultdata.message);
                                    $('#gridBody').empty();
                                    purchase_master_fetch()
                                    showsubmitbutton()
                                }
                                else
                                {
                                    alert(resultdata.message);
                                }
                            }
                        })

                    }
                }
                })
            
    </script>
</body>
</html>