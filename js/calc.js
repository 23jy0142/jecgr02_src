//手打ちした商品を会計一覧に送るｊｓ
const productPrice = 260;

      // 合計金額を計算して更新する関数
      function updateTotal() {
        let counter = document.getElementById('counter');
        let quantity = parseInt(counter.textContent); // 現在の数量
        let total = productPrice * quantity; // 合計金額
        document.getElementById('addpay_text').textContent = total; // 合計を表示
      }
      // カウントアップボタンの機能
      function btn_countup() {
        let counter = document.getElementById('counter');
        let quantity = parseInt(counter.textContent);
        counter.textContent = quantity + 1;

        // フォームに商品データを追加
        document.getElementById('product_name').value = 'レタス'; // 商品名
        document.getElementById('product_price').value = productPrice; // 価格
        document.getElementById('product_quantity').value = counter.textContent; // 数量
        // 合計金額を更新
        updateTotal();
      }

      // カウントダウンボタンの機能
      function btn_countdown() {
        let counter = document.getElementById('counter');
        let quantity = parseInt(counter.textContent);
        if (quantity > 0) {
          counter.textContent = quantity - 1;
        }

        // フォームに商品データを追加
        document.getElementById('product_name').value = 'レタス'; // 商品名
        document.getElementById('product_price').value = productPrice; // 価格
        document.getElementById('product_quantity').value = counter.textContent; // 数量
        // 合計金額を更新
        updateTotal();
      }