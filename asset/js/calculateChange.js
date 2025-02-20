function calculateChange() {
  // 合計金額を取得
  var totalAmount = parseInt(document.getElementById('total-amount').getAttribute('data-total')) || 0;
  
  var inputAmount = parseInt(document.getElementById('input-amount').value) || 0;
  var change = inputAmount - totalAmount;
  document.getElementById("input-amount").addEventListener("keydown", function (event) {
    if (!/^[0-9]$/.test(event.key) && event.key !== "Backspace" && event.key !== "Delete") {
        event.preventDefault();
    }
  });

  // おつりと不足金額を更新
  document.getElementById('change').innerText = (change >= 0 ? change : 0) + ' 円';
  document.getElementById('shortage').innerText = (change < 0 ? Math.abs(change) : 0) + ' 円';

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
