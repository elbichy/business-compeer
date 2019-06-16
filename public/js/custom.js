
//////////////////////////////////// MATERIALIZE & PLUGINS INITS //////////////////////////////////////////

$('.sidenav').sidenav();
$('.collapsible').collapsible();
$('.tooltipped').tooltip();
$('.modal').modal({
    dismissible: true
});
$('.materialboxed').materialbox();
$('select').formSelect();
$('#selectBranch').formSelect();
$('.nav-wrapper .dropdown-content li').click(function(e){
    $('form.switchBranch').submit();
});
$('.timepicker').timepicker({
    defaultTime: '9:00',
    showClearBtn: true
});
$('.tabs').tabs({
    swipeable: false
});
$('.dropdown-trigger').dropdown();


//////////////////////////////////////// GENERAL PAGE COMPONENTS SETUPS //////////////////////////////////////////

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
// if($(document).width() > '800'){
//     var doc = $(document).height();
//     var win = $(window).height();
//     var remainder = doc - win;
//     var table = $('.salesTable').height();
//     var newHeight = table - remainder + 20;
//     if(remainder > 0){
//         $('.salesTable').css({
//             'overflow-y': 'scroll',
//             'height': newHeight
//         });
//     }
//     var table2 = $('.expenseTable').height();
//     var newHeight2 = table2 - remainder;
//     if(remainder > 0){
//         $('.expenseTable').css({
//             'overflow-y': 'scroll',
//             'height': newHeight2
//         });
//     }

//     var table3 = $('.stockTable').height();
//     var newHeight3 = table3 - remainder;
//     if(remainder > 0){
//         $('.stockTable').css({
//             'overflow-y': 'scroll',
//             'height': newHeight3
//         });
//     }

//     var table4 = $('.customersTable').height();
//     var newHeight4 = table4 - remainder;
//     if(remainder > 0){
//         $('.customersTable').css({
//             'overflow-y': 'scroll',
//             'height': newHeight4
//         });
//     }
    
//     var table5 = $('.businessSettingsTable').height();
//     var newHeight5 = table5 - remainder;
//     if(remainder > 0){
//         $('.businessSettingsTable').css({
//             'overflow-y': 'scroll',
//             'height': newHeight5
//         });
//     }
    
//     var table6 = $('.branchSettingsTable').height();
//     var newHeight6 = table6 - remainder;
//     if(remainder > 0){
//         $('.branchSettingsTable').css({
//             'overflow-y': 'scroll',
//             'height': newHeight6
//         });
//     }
    
//     var table7 = $('.staffSettingsTable').height();
//     var newHeight7 = table7 - remainder;
//     if(remainder > 0){
//         $('.staffSettingsTable').css({
//             'overflow-y': 'scroll',
//             'height': newHeight7
//         });
//     }
    
//     var table8 = $('.todaysSalesTable').height();
//     var newHeight8 = table8 - remainder;
//     if(remainder > 0){
//         $('.todaysSalesTable').css({
//             'overflow-y': 'scroll',
//             'height': newHeight8
//         });
//     }
    
//     var table9 = $('.detailsArea').height();
//     var newHeight9 = table9 - remainder + 35;
//     if(remainder > 0){
//         $('.detailsArea').css({
//             'overflow-y': 'scroll',
//             'overflow-x': 'hidden',
//             'height': newHeight9
//         });
//     }
// }

function numberWithCommas(number) {
    var parts = number.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}


////////////////////////////////////////////// BUSINESS SETTINGS //////////////////////////////////////////

// GET COORDINATES
// chrome --unsafely-treat-insecure-origin-as-secure="http://bitssolutions.test"  --user-data-dir=C:\testprofile
$('.getCoordinates').click(()=>{
    getLocation();
});
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}
function showPosition(position) {
    $('#latitude').val(position.coords.latitude);
    $('#longitude').val(position.coords.longitude);
}

// DELETE A BRANCH
$('.deleteBranch').click(function(){
    let branchId = this.dataset.branchid;
    let $result = confirm('This will delete all transactions and user records registered under this branch. Are you sure you want to proceed?', false);
    if($result){
        let url = $('#deleteBranchForm').prop('action', 'delete-branch/'+branchId);
        $('#deleteBranchForm').submit();
    }
});











///////////////////////////////////////////// SALES FUNCTIONALITIES /////////////////////////////////////////////

// FUNCTION TO SUBMIT NEW SALE ASYNC
function submitSale(event){
    event.preventDefault();
    
    let type = $('#type').prop('checked') == false ? 'service' : 'product'; 
    let formData;
    if($('input[name=transactionForm]').val() == 'sales'){
        
        formData = {
            '_token'            : $('input[name=_token]').val(),
            'transactionForm'  : $('input[name=transactionForm]').val(),
            'type'              : type,
            'firstname'         : $('input[name=firstname]').val(),
            'lastname'          : $('input[name=lastname]').val(),
            'phone'             : $('input[name=phone]').val(),
            'location'          : $('input[name=location]').val(),
            'productOrService'  : $('input[name=productOrService]').val(),
            'units'             : $('input[name=units]').val(),
            'amount'            : $('input[name=amount]').val(),
            'balance'           : $('input[name=balance]').val(),
            'change'            : $('input[name=change]').val(),
        };

    }else{

        formData = $('#addSalesForm').serialize();

    }

    $('#addSalesBtn').addClass('disabled');
    $('.progress').fadeIn();
    
    // console.log(formData);

    axios.post('/dashboard/sales/storeSales', formData)
    .then(function (response) {
        if(response.data.status){
            $('.modal').modal('close');
            $.wnoty({
                type: 'success',
                message: response.data.msg,
                autohideDelay: 5000
            });
            $('#addSalesBtn').removeClass('disabled');
            $('.progress').fadeOut();
            $('#addSalesForm')[0].reset();
            response.data.from == 'sales' ? fetchNewSale(response.data.row) : response.data.from == 'transfers' ? fetchNewTransfer(response.data.row) : fetchNewUtility(response.data.row);
        }
    })
    .catch(function (error) {
        let err = error.response.data.errors;
        $('#addSalesBtn').removeClass('disabled');
        $('.progress').fadeOut();
        if('location' in err){
            if($('.locationErr').children('span')){
                $('.locationErr').children('span').remove();
            }
            $('.locationErr').append(`<span class="helper-text red-text" >
                ${err.location[0]}
            </span>`);
        }else{
            $('.locationErr').children('span').remove();
        }
        if('phone' in err){
            if($('.phoneErr').children('span')){
                $('.phoneErr').children('span').remove();
            }
            $('.phoneErr').append(`<span class="helper-text red-text" >
                ${err.phone[0]}
            </span>`);
        }else{
            $('.phoneErr').children('span').remove();
        }
        if('productOrService' in err){
            if($('.productOrServiceErr').children('span')){
                $('.productOrServiceErr').children('span').remove();
            }
            $('.productOrServiceErr').append(`<span class="helper-text red-text" >
                ${err.productOrService[0]}
            </span>`);
        }else{
            $('.productOrServiceErr').children('span').remove();
        }


        // FOR TRANSFERS

        if('accountNumber' in err){
            if($('.accountNumberErr').children('span')){
                $('.accountNumberErr').children('span').remove();
            }
            $('.accountNumberErr').append(`<span class="helper-text red-text" >
                ${err.accountNumber[0]}
            </span>`);
        }else{
            $('.accountNumberErr').children('span').remove();
        }
        
        if('accountType' in err){
            if($('.accountTypeErr').children('span')){
                $('.accountTypeErr').children('span').remove();
            }
            $('.accountTypeErr').append(`<span class="helper-text red-text" >
                ${err.accountType[0]}
            </span>`);
        }else{
            $('.accountTypeErr').children('span').remove();
        }
        
        if('amount' in err){
            if($('.amountErr').children('span')){
                $('.amountErr').children('span').remove();
            }
            $('.amountErr').append(`<span class="helper-text red-text" >
                ${err.amount[0]}
            </span>`);
        }else{
            $('.amountErr').children('span').remove();
        }
        
        if('bankName' in err){
            if($('.bankNameErr').children('span')){
                $('.bankNameErr').children('span').remove();
            }
            $('.bankNameErr').append(`<span class="helper-text red-text" >
                ${err.bankName[0]}
            </span>`);
        }else{
            $('.bankNameErr').children('span').remove();
        }
        
        if('charge' in err){
            if($('.chargeErr').children('span')){
                $('.chargeErr').children('span').remove();
            }
            $('.chargeErr').append(`<span class="helper-text red-text" >
                ${err.charge[0]}
            </span>`);
        }else{
            $('.chargeErr').children('span').remove();
        }
        
        if('firstname' in err){
            if($('.firstnameErr').children('span')){
                $('.firstnameErr').children('span').remove();
            }
            $('.firstnameErr').append(`<span class="helper-text red-text" >
                ${err.firstname[0]}
            </span>`);
        }else{
            $('.firstnameErr').children('span').remove();
        }
        
        if('lastname' in err){
            if($('.lastnameErr').children('span')){
                $('.lastnameErr').children('span').remove();
            }
            $('.lastnameErr').append(`<span class="helper-text red-text" >
                ${err.lastname[0]}
            </span>`);
        }else{
            $('.lastnameErr').children('span').remove();
        }
        
        if('recievers_firstname' in err){
            if($('.recievers_firstnameErr').children('span')){
                $('.recievers_firstnameErr').children('span').remove();
            }
            $('.recievers_firstnameErr').append(`<span class="helper-text red-text" >
                ${err.recievers_firstname[0]}
            </span>`);
        }else{
            $('.recievers_firstnameErr').children('span').remove();
        }
        
        if('recievers_lastname' in err){
            if($('.recievers_lastnameErr').children('span')){
                $('.recievers_lastnameErr').children('span').remove();
            }
            $('.recievers_lastnameErr').append(`<span class="helper-text red-text" >
                ${err.recievers_lastname[0]}
            </span>`);
        }else{
            $('.recievers_lastnameErr').children('span').remove();
        }
        
        if('recievers_phone' in err){
            if($('.recievers_phoneErr').children('span')){
                $('.recievers_phoneErr').children('span').remove();
            }
            $('.recievers_phoneErr').append(`<span class="helper-text red-text" >
                ${err.recievers_phone[0]}
            </span>`);
        }else{
            $('.recievers_phoneErr').children('span').remove();
        }
    });
}

// FUNCTION TO FETCH NEW SALE ASYNCHRONOUSLY
function fetchNewSale(data){
    if(data){
        console.log(data);
        $(`
            <tr>
                <td>${data.firstname} ${data.lastname}</td>
                <td>${data.productOrService}</td>
                <td>₦${data.amount}</td>
                ${data.balance > 0 ? `<td onclick="clearOutstanding(event)" class="clearOutstanding blue-text" data-salesId="${data.id}">+ ₦${data.balance} Bal</td>` : data.change > 0 ? `<td onclick="clearOutstanding(event)" class="clearOutstanding red-text" data-salesId="${data.id}">- ₦${data.change} Chg</td>` : `<td> NIL </td>`}
                <td>Now</td>
                <td>
                    <a onclick="loadReciept(event)" class="recieptBtn" data-salesId="${data.id}" href="#"><i class="material-icons">receipt</i></a>
                </td>
                <td>
                    <a onclick="deleteSale(event)" class=" red-text delete deleteSale" href="#delete" data-salesId="${data.id}">
                        <i class="tiny material-icons red-text">close</i>
                    </a>
                </td>
            </tr>
        `).prependTo(".salesRecordsWrap");
    }
}


// FUNCTION TO FETCH NEW TRANSFER ASYNCHRONOUSLY
function fetchNewTransfer(event){
    axios.get('/dashboard/sales/lastAddedTransfer')
    .then(function (response) {
        // handle success
        if(response.request.status == 200){
            console.log(response.data);
            $(`
            <tr>
                <td>${response.data.firstname} ${response.data.lastname}</td>
                <td>${response.data.transfer.recievers_firstname} ${response.data.transfer.recievers_lastname}</td>
                <td>${response.data.transfer.bankName}</td>
                <td>${response.data.transfer.accountType}</td>
                <td>${response.data.transfer.accountNumber}</td>
                <td>₦${numberWithCommas(response.data.transfer.amount)}</td>
                <td>₦${numberWithCommas(response.data.amount)}</td>
                <td>Now</td>
                <td>
                    ${ response.data.transfer.status == 0 ? '<i class="material-icons orange-text tooltipped" data-position="right" data-tooltip="pending">autorenew</i>' : '<i class="material-icons green-text tooltipped" data-position="right" data-tooltip="completed">done_all</i>' }
                </td>
                <td><a class="recieptBtn" data-salesId="${response.data.id}" href="#"><i class="material-icons">receipt</i></a></td>
                <td>
                    <a class="delete deleteSale" href="#delete" data-salesId="${response.data.id}">
                        <i class="tiny material-icons">close</i>
                    </a>
                </td>
                <td>
                    <a href="#">
                        <i class="tiny material-icons">question_answer</i>
                    </a>
                </td>
            </tr>
            `).prependTo(".transferRecordsWrap");
        }
    })
    .catch(function (error) {
        // handle error
        console.log(error);
    })
    .finally(function () {
        // always executed
    });
}



// FUNCTION TO FETCH NEW UTILITY ASYNCHRONOUSLY
function fetchNewUtility(event){
    axios.get('/dashboard/sales/lastAddedUtility')
    .then(function (response) {
        // handle success
        if(response.request.status == 200){
            console.log(response.data);

            let time = moment.tz(response.data.created_at, 'Africa/Lagos');
            $(`
            <tr>
                <td>${response.data.firstname} ${response.data.lastname}</td>
                <td>${response.data.utility.utilityType}</td>
                <td>${response.data.utility.utilityOptions}</td>
                <td>${response.data.utility.utilityIDnumber}</td>
                <td>₦${numberWithCommas(response.data.utility.amount)}</td>
                <td>₦${numberWithCommas(response.data.amount)}</td>
                <td>
                    <span data-livestamp="${time}"></span>
                </td>
                <td>
                    ${ response.data.utility.status == 0 ? '<i class="material-icons orange-text tooltipped" data-position="right" data-tooltip="pending">autorenew</i>' : '<i class="material-icons green-text tooltipped" data-position="right" data-tooltip="completed">done_all</i>' }
                </td>
                <td><a class="recieptBtn" data-salesId="${response.data.id}" href="#"><i class="material-icons">receipt</i></a></td>
                <td>
                    <a class="delete deleteSale" href="#delete" data-salesId="${response.data.id}">
                        <i class="tiny material-icons">close</i>
                    </a>
                </td>
                <td>
                    <a href="#">
                        <i class="tiny material-icons">question_answer</i>
                    </a>
                </td>
            </tr>
            `).prependTo(".utilityRecordsWrap");
        }
    })
    .catch(function (error) {
        // handle error
        console.log(error);
    })
    .finally(function () {
        // always executed
    });
}



// CLEAR OUTSTANDING TRIGGER
function clearOutstanding(e){
    let salesId = e.currentTarget.dataset.salesid;
    let $result = confirm('Are you sure you want to clear this outstanding payment?', false);

    let reply;
    if($result){

        let data = {
            'salesId' : salesId,
            '_token'    : $('input[name=_token]').val()
        }
        
        axios.put('/dashboard/sales/clearOutstanding', data)
        .then(function (response) {
            $(`[data-salesId="${response.data.id}"]`)[0].classList.add("black-text")
            $(`[data-salesId="${response.data.id}"]`)[0].innerHTML = 'NILL';
            $(`[data-salesId="${response.data.id}"]`)[0].previousElementSibling.innerHTML = '₦'+response.data.amount;

            console.log(response.data);
        })
        .catch(function (error) {
            // handle error
            console.log(error);
        })
    }
};

// DELETE A SALE
function deleteSale(e){
    let salesId = e.currentTarget.dataset.salesid;
    let $result = confirm('Are you sure you want to delete this transaction?', false);
    if($result){
        axios.post('/dashboard/sales/deleteSale/'+salesId,{_method: 'delete'})
        .then(function (response) {
            $(`[data-salesId="${salesId}"]`).parent().parent().remove();
        })
    }
}

// LOAD RECIEPT TRIGGER
function loadReciept(e){

    // e.preventDefault();
    var salesId = e.currentTarget.dataset.salesid;

    $.get( "/dashboard/sales/getReciept/"+salesId, function( data ) {

        $('.reciept').html(`
            <a class="printBtn" id="printBtn">
                <i class="material-icons">print</i>
            </a>
            <div class="recieptTop col s12">
                <div class="logoArea">
                    <img src="/storage/site/${data.business.name}/${data.business.logo}" alt="logo">
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

}

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

// LOAD NOTIFICATION ASYNC
function loadNotification(base_url){
    let count = $('.notificationCount')[0].innerHTML;
    axios.get('/dashboard/sales/load-notification/'+count)
    .then(function (response) {
        response.data.newCount != 0 ?  $('.notificationCount').removeClass('green') : '';
        if(response.data.greater){
            $(`
                <li>
                    <a href="${response.data.data.data.data.url}">
                        <i class="material-icons">monetization_on</i>
                        <div class='notMsg'>
                            <p>${response.data.data.data.data.msg}</p>
                            <sub data-livestamp="${moment.tz(response.data.data.created_at, 'Africa/Lagos')}"></sub>
                        </div>
                        
                    </a>
                </li>
            `).prependTo("#notifications");


            ion.sound({
                sounds: [
                    {
                        name: "door_bell"
                    }
                ],
                volume: 0.5,
                path: base_url+"/sounds/",
                preload: true
            });
            ion.sound.play("door_bell");
            console.log(response.data.data);
        }
        $('.notificationCount').html(response.data.newCount);
    })
    .catch(function (error) {
        // handle error
        console.log(error);
    })
    .finally(function () {
        // always executed
    });
}









////////////////////////////////////////// EXPENSES FUNCTIONALITIES /////////////////////////////////////////////

// DELETE A EXPENSE
$('.deleteExpense').click(function(){
    let expenseId = this.dataset.expenseid;
    let $result = confirm('Are you sure you want to delete this transaction?', false);
    if($result){
        let url = $('#deleteExpenseForm').prop('action', '/dashboard/expenses/delete-expense/'+expenseId);
        $('#deleteExpenseForm').submit();
    }
});









////////////////////////////////////////// STOCK FUNCTIONALITIES /////////////////////////////////////////////

// DELETE A STOCK ITEM
$('.deleteStock').click(function(){
    let stockId = this.dataset.stockid;
    let $result = confirm('Are you sure you want to delete this item?', false);
    if($result){
        let url = $('#deleteStockForm').prop('action', '/dashboard/stock/deleteStock/'+stockId);
        $('#deleteStockForm').submit();
    }
});
