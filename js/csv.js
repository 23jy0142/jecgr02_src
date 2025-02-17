document.addEventListener("DOMContentLoaded", function () {
  fetch("../../../sample_datafile/item_stock.csv")
    .then((response) => {
      if (!response.ok) {
        throw new Error("csvファイルの取得に失敗しました");
      }
      return response.text();
    })
    .then((data) => parseCSV(data))
    .catch((error) => console.error("エラー：", error));
});

let currentPage = 0; // 現在のページ番号
const rowPerPage = 10; // 1ページあたりの行数

function parseCSV(data) {
  const lines = data.trim().split("\n"); // CSVデータを行ごとに分割
  const tableBody = document.getElementById("csvBody"); // テーブルボディ要素を取得

  // データ行のみを保持
  const dataRows = lines.slice(1);

  function renderRows() {
    tableBody.innerHTML = ""; // テーブルボディをクリア

    const start = currentPage * rowPerPage;
    const end = start + rowPerPage;

    const rowsToDisplay = dataRows.slice(start, end);
    rowsToDisplay.forEach((line) => {
      const row = document.createElement("tr"); // 行要素を作成
      const cells = line.split(","); // カンマで分割してセルデータを取得

      // 各データセルを追加
      cells.forEach((cell) => {
        const td = document.createElement("td");
        td.textContent = cell.trim();
        row.appendChild(td);
      });

      // 詳細リンクを追加
      const detailTd = document.createElement("td");
      const detailLink = document.createElement("a");
      detailLink.href = "./uw202_3.html";
      detailLink.textContent = "詳細";
      detailLink.addEventListener("click", (event) => {
        event.preventDefault();
        const rowData = cells.map((cell) => cell.trim());

        // データをオブジェクト形式にして格納
        const rowDataObject = {
          商品ID: rowData[0],
          商品名: rowData[1],
          価格: rowData[2],
          カテゴリ: rowData[3],
          メーカー: rowData[4],
          在庫数: rowData[5],
          賞味期限: rowData[6],
        };

        // すべてのローカルストレージを削除
        localStorage.clear();

        // 新しいデータを追加
        let storedData = [];
        storedData.push(rowDataObject);
        localStorage.setItem("itemDetails", JSON.stringify(storedData));

        // 次のページに遷移
        window.location.href = detailLink.href;
      });
      detailTd.appendChild(detailLink);
      row.appendChild(detailTd);

      tableBody.appendChild(row); // テーブルボディに行を追加
    });

    // ページ番号の更新
    document.getElementById("current_page").textContent = currentPage + 1;
  }

  renderRows();

  // ページ切り替えボタンの処理
  document.querySelector(".plus_btn").addEventListener("click", function () {
    if ((currentPage + 1) * rowPerPage < dataRows.length) {
      currentPage++;
      renderRows();
    }
  });

  document.querySelector(".minus_btn").addEventListener("click", function () {
    if (currentPage > 0) {
      currentPage--;
      renderRows();
    }
  });
}
