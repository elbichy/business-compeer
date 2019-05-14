$(document).ready(function () {

    // MATERIALIZE INITS
    $('.sidenav').sidenav();
    $('.collapsible').collapsible();
    $('.modal').modal({
        dismissible: true
    });
    $('.materialboxed').materialbox();
    $('select').formSelect();
    $('#selectBranch').formSelect();
    $('.nav-wrapper .dropdown-content li').click(function(e){
        $('form.switchBranch').submit();
    });
    $('.addSaleSubmitBtn').click(function(e){
        $('form.addSalesForm').submit();
    });
    $('.timepicker').timepicker({
        defaultTime: '9:00',
        showClearBtn: true
    });
    $('.tabs').tabs({
        swipeable: false
    });

    // SUBMIT PRELOADER
    $('form').submit(function(e){
        // e.preventDefault();
        var elem = e.currentTarget.querySelector('.btnWrap>button');
        // console.log(elem);
        $(elem).fadeOut(function(){
            $('.preloader-wrapper').fadeIn();
        });
    });

    // TABLE HEIGHT AUTO ADJUSTMENT
    if($(document).width() > '800'){
        var doc = $(document).height();
        var win = $(window).height();
        var remainder = doc - win;
        var table = $('.salesTable').height();
        var newHeight = table - remainder + 20;
        if(remainder > 0){
            $('.salesTable').css({
                'overflow-y': 'scroll',
                'height': newHeight
            });
        }
        var table2 = $('.expenseTable').height();
        var newHeight2 = table2 - remainder;
        if(remainder > 0){
            $('.expenseTable').css({
                'overflow-y': 'scroll',
                'height': newHeight2
            });
        }

        var table3 = $('.stockTable').height();
        var newHeight3 = table3 - remainder;
        if(remainder > 0){
            $('.stockTable').css({
                'overflow-y': 'scroll',
                'height': newHeight3
            });
        }

        var table4 = $('.customersTable').height();
        var newHeight4 = table4 - remainder;
        if(remainder > 0){
            $('.customersTable').css({
                'overflow-y': 'scroll',
                'height': newHeight4
            });
        }
        
        var table5 = $('.businessSettingsTable').height();
        var newHeight5 = table5 - remainder;
        if(remainder > 0){
            $('.businessSettingsTable').css({
                'overflow-y': 'scroll',
                'height': newHeight5
            });
        }
        
        var table6 = $('.branchSettingsTable').height();
        var newHeight6 = table6 - remainder;
        if(remainder > 0){
            $('.branchSettingsTable').css({
                'overflow-y': 'scroll',
                'height': newHeight6
            });
        }
        
        var table7 = $('.staffSettingsTable').height();
        var newHeight7 = table7 - remainder;
        if(remainder > 0){
            $('.staffSettingsTable').css({
                'overflow-y': 'scroll',
                'height': newHeight7
            });
        }
        
        var table8 = $('.todaysSalesTable').height();
        var newHeight8 = table8 - remainder;
        if(remainder > 0){
            $('.todaysSalesTable').css({
                'overflow-y': 'scroll',
                'height': newHeight8
            });
        }
        
        var table9 = $('.detailsArea').height();
        var newHeight9 = table9 - remainder + 35;
        if(remainder > 0){
            $('.detailsArea').css({
                'overflow-y': 'scroll',
                'overflow-x': 'hidden',
                'height': newHeight9
            });
        }
    }


    // CLEAR OUTSTANDING
    $('.clearOutstanding').click(function(){
        let salesId = this.dataset.salesid;
        let $result = confirm('Are you sure you want to clear this outstanding payment?', false);
        if($result){
            let url = $('#clearOutstandingForm').prop('action', 'clearOutstanding/'+salesId);
            $('#clearOutstandingForm').submit();
        }
    });

    // DELETE A SALE
    $('.deleteSale').click(function(){
        let salesId = this.dataset.salesid;
        let $result = confirm('Are you sure you want to delete this transaction?', false);
        if($result){
            let url = $('#deleteSaleForm').prop('action', 'deleteSale/'+salesId);
            $('#deleteSaleForm').submit();
        }
    });
    
    // DELETE A EXPENSE
    $('.deleteExpense').click(function(){
        let expenseId = this.dataset.expenseid;
        let $result = confirm('Are you sure you want to delete this transaction?', false);
        if($result){
            let url = $('#deleteExpenseForm').prop('action', 'deleteExpense/'+expenseId);
            $('#deleteExpenseForm').submit();
        }
    });
    
    // DELETE A STOCK ITEM
    $('.deleteStock').click(function(){
        let stockId = this.dataset.stockid;
        let $result = confirm('Are you sure you want to delete this item?', false);
        if($result){
            let url = $('#deleteStockForm').prop('action', 'deleteStock/'+stockId);
            $('#deleteStockForm').submit();
        }
    });


    // LOAD RECIEPT TRIGGER
    $('.recieptBtn').click(function(e){

        e.preventDefault();
        var salesId = e.currentTarget.dataset.salesid;

        $.get( "/Dashboard/getReciept/"+salesId, function( data ) {

            $('.reciept').html(`
                <a class="printBtn" id="printBtn">
                    <i class="material-icons">print</i>
                </a>
                <div class="recieptTop col s12">
                    <div class="logoArea">
                        <img src="/storage/site/${data.business.logo}" alt="logo">
                    </div>
                    <h6 class="businessName">
                        ${data.business.name}
                    </h6>
                    <small class="branchAddress">
                        ${data.branch.name} - ${data.branch.address}
                    </small>
                    <p class="recieptTitle">
                        <b>Transaction Reciept</b>
                    </p>
                </div>
                <div class="recieptBottom col s12">
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                    Transaction Type:
                                </td>
                                <td>
                                    ${data.type}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Transaction Title:
                                </td>
                                <td>
                                    ${data.productOrService}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Customer Fullname:
                                </td>
                                <td>
                                    ${data.firstname} ${data.lastname}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Customer Phone:
                                </td>
                                <td>
                                    ${data.phone}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Customer Address:
                                </td>
                                <td>
                                    ${data.location}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Units:
                                </td>
                                <td>
                                    ${data.units}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Paid:
                                </td>
                                <td>
                                    ₦${data.amount}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Balance:
                                </td>
                                <td>
                                    ₦${data.balance}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Change:
                                </td>
                                <td>
                                    ₦${data.change}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            `);

            $('.printBtn').click(function(){
                printReciept();
            });

        });
        $('.reciept').html(`
            <div class="preloader-wrapper active">
                <div class="spinner-layer spinner-green-only">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div><div class="gap-patch">
                    <div class="circle"></div>
                </div><div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
                </div>
            </div>
        `);

    });
    
    // PRINT RECIEPT FUNCTION
    function printReciept() {
        var content = document.querySelector('.reciept').innerHTML;
        var mywindow = window.open('', 'Print', 'height=462,width=330.703');
    
        mywindow.document.write('<html><head><title>Print</title>');
        mywindow.document.write('</head><body >');
        mywindow.document.write(content);
        mywindow.document.write('</body></html>');
    
        mywindow.document.close();
        mywindow.focus()
        mywindow.print();
        mywindow.close();
        return true;
    }


});
