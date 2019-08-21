method = {
    invoiceWrapper    : $(".invoiceContainer"),
    invoiceBackground : $(".invoiceBackground"),
    inputAmount       : $("#payAmount"),
    bankWire          : $("#payAmountBankWire"),
    amountSubmit      : $("#amountSubmit"),
    stopTracker       : q("#stopTracker"),
    track             : null,
    amountCallback1   : $("#amountCallback"),
    amountCallback2   : $("#amountCallback2"),
    generateInvoice : $("#amountSubmitBankWire"),


    process: function () {

        method.inputAmount.on("keyup", function() {
            method.displayPlan(method.inputAmount.val(), method.amountCallback);
        });

        method.bankWire.on("keyup", function() {
            method.displayPlan(method.bankWire.val(), method.amountCallback2);
        });

        method.amountSubmit.on("click" ,  function() {
            method.stopTracker.dataset.check = "not-approved";
            

            $.post(URL+"Dashboard/ajaxCreateInvoice", "amount="+method.inputAmount.val(), function (response, status) {
                
                
                if (status === "success") {
                    
                    try {

                        
                        var data = JSON.parse(response);
                       
                        
                        /*if (data === true) {
                            window.location.href = URL+"Settings";
                            return false;
                        } */

                        method.invoiceWrapper.css("display", "block");
                        method.invoiceBackground.css("display", "block");

                        method.invoiceWrapper.html(
                            '<div id="invoice" class="invoice">'+
                                '<div class="invoiceHead">'+
                                    '<div class="invoiceTitle">'+
                                        '<div class="appname">'+APP_NAME+'</div>'+
                                        '<div class="invoiceNumber" id="invoiceNumber"></div>'+
                                    '</div>'+
                                '</div>'+
                        
                                '<div class="invoiceProcess">'+
                                    
                                    '<div>Please don\'t close this window</div>'+
                                    '<div>'+
                                        '<img class="preload" src="'+URL+'/public/images/loader2.gif"> '+
                                        'Awaiting payment....'+
                                    '</div>'+
                                '</div>'+
                                
                                '<div class="invoiceBody">'+
                                    '<div class="invoiceBodySectionOne">'+
                                        '<div class="invoiceBodySectionOneWrapper">'+
                                            '<div class="exchanger">'+
                                                '<div id="exchange"></div>'+
                                            '</div>'+
                                            '<div class="btcPrice">'+
                                                '<div id="btcPrice"></div>'+
                                                '<div id="btcRate"></div>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="invoiceBodySectionTwo">'+
                                        '<div class="qrCodeContainer">'+
                                            '<div id="qrcode"></div>'+
                                        '</div>'+
                                        '<div class="addressContainer">'+
                                            '<div>Alternatively, copy and pay to this address</div>'+
                                            '<div id="btcAddress"></div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="invoiceFooter">'+
                                    '<button class="btn btn-block btn-danger" id="cancelPayment">Cancel</button>'+
                                '</div>'+
                            '</div>'
                        );

                        var invoiceContainer = $("#invoice"),
                            qrCodeContainer  = $("#qrcode"),
                            invoiceNumber    = $("#invoiceNumber"),
                            exchange         = $("#exchange"),
                            btcPrice         = $("#btcPrice"),
                            btcRate          = $("#btcRate"),
                            btcAddress       = $("#btcAddress"),
                            cancelPayment    = $("#cancelPayment");

                        data.btc_amount = data.btc_amount;

                        invoiceNumber.html("Invoice No: "+data.label);
                        exchange.html(data.exchanger);
                        btcPrice.html(data.btc_amount+" BTC");
                        btcRate.html("1 BTC = "+data.currency+""+data.rate);
                        qrCodeContainer.qrcode({text: data.address}); // Btc address qrcode
                        btcAddress.html(data.address);


                        

                        // Track payment
                        method.track = setInterval(function() { 
                            if (method.stopTracker.dataset.check === "approved") {
                                method.invoiceWrapper.html(
                                    "<div class='invoiceAction'> "+
                                        "<span class='fa fa-check-circle-o' style='font-size: 200%'></span>"+
                                        "<div>Your payment has been accepted</div>"+
                                        "<div><button id='closeInvoice' class='btn btn-success'>Exit</button></div>"+
                                    "</div>"
                                );

                                $("#closeInvoice").on("click", function() {
                                    method.invoiceWrapper.css("display", "none");
                                    method.invoiceBackground.css("display", "none");
                                    window.location.href = URL+"Dashboard";
                                });
                                
                                clearInterval(method.track);

                                return false;
                            }
                            method.trackPayment(data.label,data.btc_amount,data.invoice_id); 

                        }, 3000);

                        // Enable cancel invoice button
                        method.cancelOrder(cancelPayment, data.address,method.track);

                        
                    } catch(e) {

                        if (response == "redirect") {
                            window.location.href = URL+"Settings";
                        }
                        method.amountCallback.css("display", "block");
                        method.amountCallback.html(
                            "<div class='alert alert-danger'>"+
                                "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>"+    
                                    "<span aria-hidden='true'>×</span><span class='sr-only'>Close</span>"+
                                "</button>"+
                                response+
                            "</div>"    
                        );
                        console.log(response);
                    }
                    
                }
            }); 
        });


        method.generateInvoice.on("click", function() {
            $.post(`${URL}Dashboard/AjaxBankWireInvoice`, {amount: method.bankWire.val() },  function(response, status) {
                if (status === "success") {
                    try {
                        var data = JSON.parse(response);

                        if (data === true) {
                            // Display bank account information
                            $("#bankWirePaymentForm").html(
                                `   <div>
                                        <div class='alert alert-success'>Invoice has been generated successfully.</div>
                                        <div class='alert alert-primary'>Please make payment to the following bank account</div>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Bank Name</th>
                                                        <th>Bank Address</th>
                                                        <th>Account Number</th>
                                                        <th>Routing Number</th>
                                                        <th>Account</th>
                                                        <th>Account Name</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>US Bank</td>
                                                        <td>39390 Fremont BBlvd Fremont, CA 94538 US</td>
                                                        <td>157515261640</td>
                                                        <td>121122676</td>
                                                        <td>Checking</td>
                                                        <td>Wanlapasiri K Person</td>
                                                    <tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                `
                            );

                        } else {
                            // Display server printed error
                        }
                    } catch(e) {

                    }
                }
            });
        });
        
    },

    trackPayment : function (label,amount,invoice) {
        
        var data = "label="+label+"&amount="+amount+"&invoice="+invoice;
        $.post(URL+"Dashboard/ajaxTrackPayment", data, function(response, status) {
            if (status === "success") {

                try {
                    var $data = JSON.parse(response);
                    if ($data === true) {
                        method.stopTracker.dataset.check = "approved"; 
                    }
                } catch(e) {
                    console.log(response);
                }
                
            }
        });
    },

    cancelOrder: function(cancelPayment,address,cancelTracker)  {
        
        cancelPayment.on("click", function(){
            clearInterval(cancelTracker);
            var data = "address="+address;
            $.post(URL+"Dashboard/ajaxCancelInvoice", data, function (response, status) {

                if (status === "success") {
                    try {
                        var data = JSON.parse(response);
                        if (data === true) {
                            method.invoiceWrapper.html(
                                "<div class='invoiceAction'> "+
                                    "<span class='fa fa-times' style='font-size: 200%'></span>"+
                                    "<div>Your payment has been canceled</div>"+
                                    "<div><button id='closeInvoice' class='btn btn-info'>Exit</button></div>"+
                                "</div>"
                            );
    
                            $("#closeInvoice").on("click", function() {
                                method.invoiceWrapper.css("display", "none");
                                method.invoiceBackground.css("display", "none");
                            });
                        }
                    } catch(e) {
                        console.log(response);
                    }
                }
                
            });
        }); 
    },

    displayPlan: function(amount, callback) {
        var data = {amount: amount};
        
        $.post(URL+"Plan/calculator", data, function(response, status) {
           
            if (status === "success") {
                try {
                    var json = JSON.parse(response);
                 
                    var planName = $("#fist-name"), duration = $("#duration"), average = $("#average"),
                    rio = $("#s1");
    
                        if (json === false) {
                            planName.val("");
                            duration.val("");
                            average.val("");
                            callback.css("display", "block");
                            callback.html(
                                "<div class='alert alert-danger'>"+
                                    "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>"+    
                                        "<span aria-hidden='true'>×</span><span class='sr-only'>Close</span>"+
                                    "</button>"+
                                    "Sorry the amount you entered is either invalid or out of range"+
                                "</div>"
                            );
    
                        } else {
                            callback.css("display", "none");
    
                            planName.val(json.name);
                            duration.val(json.daily_profit_min+"%");
                            average.val(json.daily_profit_max+"%");
                           // rio.val(json.symbol+json.rio);
                        }
                } catch(e) {
                    // console.log(response);
                }
                
            }
        });
    },
};

method.process();
