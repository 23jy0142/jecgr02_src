function createReceipt(inputAmount, trading_information_id) {
    // フォームを動的に作成
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '../../view/self_register/sample_pdf.php';
    // form.target を削除すれば同じ画面で遷移します

    // inputAmountを追加
    const input1 = document.createElement('input');
    input1.type = 'hidden';
    input1.name = 'inputAmount';
    input1.value = inputAmount;
    form.appendChild(input1);

    // trading_information_idを追加
    const input2 = document.createElement('input');
    input2.type = 'hidden';
    input2.name = 'trading_information_id';
    input2.value = trading_information_id;
    form.appendChild(input2);

    // フォームをbodyに追加して送信
    document.body.appendChild(form);
    form.submit();
}
