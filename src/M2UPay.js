var M2UPay = {
  initPayment:function(el,encString,action,subService)
  {
    html = '<form action="" name="M2UPayment" target="M2UPayment" method="post" onsubmit="return false;"><input type="hidden" name="q" value="" id="q"><input type="hidden" name="i" value="OT" id="i"><input type="button" value="Confirm" ng-click="makepaymentM2u()" style="display: none;"></form>'; 
    document.getElementById(el).innerHTML = html;
    var q = document.getElementById('q');
    var i = document.getElementById('i');
    q.value = encString;
    i.value = subService;
    document.M2UPayment.target = "M2UPayment";
    document.M2UPayment.action = action;
    m2uPopup = window.open('about:self', 'M2UPayment', 'width=400,height=350');
    document.M2UPayment.submit();
    document.getElementById(el).innerHTML = ""; 
  }
}