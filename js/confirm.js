 // URLクエリパラメータを取得
 const urlParams = new URLSearchParams(window.location.search);

 // データを取得
 const itemId = urlParams.get("item_id");
 const itemName = urlParams.get("item_name");
 const category = urlParams.get("category");
 const maker = urlParams.get("maker");
 const taxRate = urlParams.get("tax_rate");
 const salesPrice = urlParams.get("sales_price");
 const itemStock = urlParams.get("item_stock");
 const arrivalDate = urlParams.get("arrival_date");

 // データを表示
 document.getElementById("item_details").innerHTML = `
   <p>商品ID: ${itemId}</p>
   <p>商品名: ${itemName}</p>
   <p>カテゴリ: ${category}</p>
   <p>メーカー: ${maker}</p>
   <p>消費税設定: ${taxRate}%</p>
   <p>販売価格: ${salesPrice}円</p>
   <p>在庫数: ${itemStock}</p>
   <p>入荷日: ${arrivalDate}</p>
 `;