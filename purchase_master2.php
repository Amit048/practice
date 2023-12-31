<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    <style>

h2 {
    color: green;
}

label {
    display: inline-block;
    width: 100px;
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
        <form action="" method="POST" id="mypage">
            <h2>Purchase Master:</h2>
            <label for="purchasename">Purchase Name</label><br>
            <input type="text" name="purchasename" id="purchasename">
            <hr><br><br>
            <h2>Purchase Details</h2>
            <label for="Category">Category</label>
            <select name="catid" id="catid">
            <option value="" selected>Select Category</option>
            </select>
            <label for="Category">Subcategory</label>
            <select name="subcatid" id="subcatid">
            <option value="" selected>Select SubCategory</option>
            </select>
            <label for="Category">Item</label>
            <select name="itemid" id="itemid">
            <option value="" selected>Select item</option>
            </select>
            <label for="itemamount">itemamount</label>
            <input type="text" name="itemamount" id="itemamount">

            <label for="quantity">quantity</label>
            <input type="text" name="quantity" id="quantity">

           <button type="button" id="addData" name="addData">Add</button>

           <h2>Grid Details</h2>
           <table>
            <thead>
                <tr>
                    <td>Category</td>
                    <td>Subcategory</td>
                    <td>Item</td>
                    <td>Item Amount</td>
                    <td>Quantity</td>
                </thead>
            </tr>
            <tbody id="gridBody">
                
                </tbody>
            </table>
            <br><br>
            <input type="submit" value="submit" name="submit" id="submit">
            <input type="hidden" name="purchaseid" id="purchaseid">
           <input type="submit" value="Update" id="updateId" name="updateId">
           <input type="hidden" id="id">
        </form>
    </center>

    <center>
        <h2>Purchase Details</h2>
        <table>
            <thead>
                <tr>
                    <td>PurchaseName</td>
                    <td>Action</td>
                </tr>
            </thead>

            <tbody id="purchaseBody">

            </tbody>
        </table>
    </center>

    <center>
        <div id="popupBox">
            <h2>Purchase Master Details</h2>
            <table id="popupTable">

            </table>
            <button type="button" onClick="closepopup()">Close</button>
        </div>
    </center>
    
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
        <script>
            $(document).ready(function(){
                category()
                purchase_master_fetch();
                showsubmitbutton()
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
            subcategory()
        })
        function subcategory()
        {
           var catid = $('#catid').val()
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
                        $('#subcatid').html(table)
                        ItemMaster()
                    }
                    else
                    {
                        alert(resultdata.message);
                    }
                }
            });
        }

        $('#subcatid').change(function(){
            ItemMaster();
        })

        $('#itemid').change(function(){
            var itemselect = $('#itemid option:selected');
            var itemamount = itemselect.attr('itemamount');
            $('#itemamount').val(itemamount)
        })
        
        function ItemMaster()
        {
           var subcatid = $('#subcatid').val()
            $.ajax({
                method:'POST',
                url:'item_Fetch.php',
                dataType:'json',
                data:{subcatid:subcatid,flag:1},
                success:function(data)
                {
                    var jsonData = JSON.stringify(data);
                    var resultdata = jQuery.parseJSON(jsonData);

                    if(resultdata.status == 1)
                    {
                        var table = '';
                        table += '<option value = "">Select Item</option>';
                        for(var i in resultdata.categorydata)
                        {
                            table += '<option value= "' +resultdata.categorydata[i].id+ '" itemamount="' +resultdata.categorydata[i].itemamount+ '">'+resultdata.categorydata[i].itemname+'</option>';
                        }
                        $('#itemid').html(table)
                       
                    }
                    else
                    {
                        alert(resultdata.message);
                    }
                }
            });
        }

        $('#addData').click(function(){
            var catid = $('#catid').val();
            var catname = $('#catid option:selected').text();
            var subcatid = $('#subcatid').val();
            var subcatname = $('#subcatid option:selected').text()
            var itemid = $('#itemid').val();
            var itemname = $('#itemid option:selected').text();
            var itemamount = $('#itemamount').val();
            var quantity = $('#quantity').val();

            var table = '';
            table += '<tr>';
            table += '<td><input type="hidden" id="tblcatid" name="tblcatid[]" value="'+catid+'"><input type="hidden" id="tblcatname" name="tblcatname[]" value="'+catname+'">' + catname+'</td>';

            table += '<td><input type="hidden" id="tblsubcatid" name="tblsubcatid[]" value="'+subcatid+'"><input type="hidden" id="tblsubcatname" name="tblsubcatname[]" value="'+subcatname+'">' + subcatname+'</td>';

            table += '<td><input type="hidden" id="tblitemid" name="tblitemid[]" value="'+itemid+'"><input type="hidden" id="tblitemname" name="tblitemname[]" value="'+itemname+'">' + itemname+'</td>';

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
        });

       function removeRow(button)
       {
            $(button).closest('table tr').remove()
       }


       $('#purchaseBody').on('click','.showRecoard',function(){
            var purchaseid = $(this).attr('data-id');
            //$('#purchaseid').val(purchaseid)
            console.log("Purchase id:" + purchaseid);
            purchase_details_fetch(purchaseid);
       })
       function closepopup()
       {
            $('#popupBox').hide()
       }

       function purchase_master_fetch(purchaseid)
       {
            $.ajax({
                url:'purchase_master_fetch2.php',
                dataType:'json',
                method:'POST',
                data:{purchaseid:purchaseid},
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
                            table += '<td><a class="showRecoard" data-id="'+resultdata.categorydata[i].id+'">'+resultdata.categorydata[i].purchasename+'</a></td>';

                            table += '<td><a href="javascript:void(0)" class="deleteRecoard" data-id="' + resultdata.categorydata[i].id + '">Delete</a></td>';

                            table += '<td><a href="javascript:void(0)" class="editRecoard" data-id="' + resultdata.categorydata[i].id + '" >Edit</a></td>';
                            table += '</tr>';
                        }
                        $('#purchaseBody').html(table)
                    }
                }
            })
       }


       function purchase_details_fetch(purchaseid)
       {
            $.ajax({
                method:'POST',
                url:'purchase_details_fetch2.php',
                dataType:'json',
                data:{purchaseid:purchaseid},
                success:function(data)
                {
                    var jsonData = JSON.stringify(data);
                    var resultdata = jQuery.parseJSON(jsonData);

                    if(resultdata.status == 1)
                    {
                        var table = '';
                        table += '<thead><tr><th>Category</th><th>Subcategory</th><th>Item</th><th>Item Amount</th><th>Quantity</th></tr></thead><tbody>';
                        for(var i in resultdata.categorydata)
                        {
                            table += '<tr>';
                            table += '<td>'+resultdata.categorydata[i].catid+'</td>'
                            table += '<td>'+resultdata.categorydata[i].subcatid+'</td>'
                            table += '<td>'+resultdata.categorydata[i].itemid+'</td>'
                            table += '<td>'+resultdata.categorydata[i].itemamount+'</td>'
                            table += '<td>'+resultdata.categorydata[i].quantity+'</td>'
                            table += '</tr>'
                        }
                        $('#popupTable').html(table);
                        $('#popupBox').show()
                    }
                }
            })
       }

       $('#purchaseBody').on('click','.deleteRecoard',function(){
        var purchaseid = $(this).attr('data-id');
        purchase_delete(purchaseid)
       })
       
       function purchase_delete(purchaseid)
       {
        $.ajax({
            method:'POST',
            url:'purchase_delete2.php',
            dataType:'json',
            data:{purchaseid:purchaseid},
            success:function(data)
            {
                var jsonData = JSON.stringify(data);
                var resultdata = jQuery.parseJSON(jsonData);

                if(resultdata.status == 1)
                {
                    alert(resultdata.message)
                    purchase_master_fetch()
                }
                else
                {
                    alert(resultdata.message)
                }
            }
        })
       }

       $('#purchaseBody').on('click','.editRecoard',function(){
        var purchaseid = $(this).attr('data-id');
        purchase_edit(purchaseid)
       });

       function purchase_edit(purchaseid)
       {
        $.ajax({
            method:'POST',
            url:'purchase_edit2.php',
            data:{purchaseid:purchaseid},
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
                        var tblcatid = resultdata.categorydata[i].catid;
                        var tblcatname = resultdata.categorydata[i].catname;
                        var tblsubcatid = resultdata.categorydata[i].subcatid;
                        var tblsubcatname = resultdata.categorydata[i].subcatname;
                        var tblitemid = resultdata.categorydata[i].itemid;
                        var tblitemname = resultdata.categorydata[i].itemname;
                        var tblitemamount = resultdata.categorydata[i].itemamount;
                        var tblquantity = resultdata.categorydata[i].quantity;

                        table += '<tr>';
                        table += '<td><input type="hidden" id="tblcatid" name="tblcatid[]" value="'+tblcatid+'"><input type="hidden" id="tblcatname" name="tblcatname[]" value="'+tblcatname+'">' + tblcatname+'</td>';

                        table += '<td><input type="hidden" id="tblsubcatid" name="tblsubcatid[]" value="'+tblsubcatid+'"><input type="hidden" id="tblsubcatname" name="tblsubcatname[]" value="'+tblsubcatname+'">' + tblsubcatname+'</td>';

                        table += '<td><input type="hidden" id="tblitemid" name="tblitemid[]" value="'+tblitemid+'"><input type="hidden" id="tblitemname" name="tblitemname[]" value="'+tblitemname+'">' + tblitemname+'</td>';

                        table += '<td><input type="hidden" id="tblitemamount" name="tblitemamount[]" value="'+tblitemamount+'">' + tblitemamount + '</td>';
                        table += '<td><input type="hidden" id="tblquantity" name="tblquantity[]" value="'+tblquantity+'">' + tblquantity + '</td>';
                        table += '<td><button class="removeRow" onclick="removeRow(this)">❎</button></td>'
                        table += '</tr>';
                    }
                    $('#gridBody').html(table);
                    $('#id').val(resultdata.id);
                    //$('#purchaseid').val(resultdata.purchaseid);
                    $('#purchasename').val(resultdata.purchasename);
                    $('#catid').val(resultdata.catid); 
                    $('#subcatid').val(resultdata.subcatid); 
                    $('#itemid').val(resultdata.itemid); 
                    $('#itemamount').val(resultdata.itemamount); 
                    $('#quantity').val(resultdata.quantity); 
                    showupdatebutton()
                }
            }
        })
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

        $('#mypage').validate({
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
                    if ($('#purchaseid').val() == '') 
                    {
                        var url = 'purchase_insert2.php';
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
                                    $('#purchaseid').val('');
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