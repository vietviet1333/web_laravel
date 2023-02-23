<body> 

    
    
    <div id="paypal-button-container" class="text-center mt-5 mb-5"></div> 
    
    
    
    </body> 
    
     
    
     
    
    <script src="https://www.paypalobjects.com/api/checkout.js"></script> 
    
    <script> 
    
     paypal.Button.render({ 
    
     env: 'sandbox', // sandbox | production 
    
     // PayPal Client IDs - replace with your own 
    
     // Create a PayPal app: https://developer.paypal.com/developer/applications/create 
    
     client: { 
    
      sandbox: 'AaxcnRFELDjYW5J2VocniwORG3EAZWoJ_jk8yXkGdQYEhIqwfsdrw6PRSoQ7xWrBrHSaybNWxim5UvBn', 
    
      production: '<insert production client id>' 
    
     }, 
    
     // Show the buyer a 'Pay Now' button in the checkout flow 
    
     commit: true, 
    
     // payment() is called when the button is clicked 
    
     payment: function(data, actions) { 
    
      var usd=document.getElementById("vnd_to_usd").value; 
    
      // Make a call to the REST api to create the payment 
    
      return actions.payment.create({ 
    
      payment: { 
    
       transactions: [ 
    
       { 
    
        amount: { total: `${usd}`, currency: 'USD' } 
    
       } 
    
       ] 
    
      } 
    
      }); 
    
     }, 
    
     // onAuthorize() is called when the buyer approves the payment 
    
     onAuthorize: function(data, actions) { 
    
      // Make a call to the REST api to execute the payment 
    
      return actions.payment.execute().then(function() { 
    
      // window.alert('Payment Complete!'); 
    
      window.location.href = '/PurchaseHistorys'; 
    
      }); 
    
     } 
    
     }, '#paypal-button-container'); 
    
    </script> 
    
     