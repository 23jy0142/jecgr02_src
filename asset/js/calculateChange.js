function calculateChange() {
  // 合計金額を取得
  var totalAmount = Math.round(parseInt(document.getElementById('total-amount-tax').getAttribute('data-total')) || 0);

  var inputAmount = Math.round(parseInt(document.getElementById('input-amount').value) || 0);
  var change = Math.round(inputAmount - totalAmount);
  var pay_change = Math.round(totalAmount - inputAmount);
  if(pay_change < 0){
    pay_change = 0;
  }
  document.getElementById("input-amount").addEventListener("keydown", function (event) {
    if (!/^[0-9]$/.test(event.key) && event.key !== "Backspace" && event.key !== "Delete") {
        event.preventDefault();
    }
  });

  // おつりと不足金額を更新

  document.getElementById('change').innerText = (change >= 0 ? change : 0) + ' 円';
  document.getElementById('pay_change').innerText = pay_change + ' 円';
  // 支払い完了ボタンの有効化・無効化
  var paymentButton = document.getElementById('complete-payment');
  paymentButton.disabled = (change < 0);

  if (change >= 0) {
    paymentButton.setAttribute("onclick", 
      `location.href='../../view/self_register/complete.php?method=cash&total_amount=${totalAmount}&input_amount=${inputAmount}'`);
  } else {
    paymentButton.removeAttribute("onclick");
  }
}
