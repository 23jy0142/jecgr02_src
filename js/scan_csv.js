document.addEventListener("DOMContentLoaded", function () {
    fetch("../../../sample_datafile/item_scan.csv")
      .then((response) => {
        if (!response.ok) {
          throw new Error("csvファイルの取得に失敗しました");
        }
        return response.text();
      })
      .then((data) => parseCSV(data))
      .catch((error) => console.error("エラー：", error));
  });
  
  let statusCells = []; // 登録状況セルのリスト
  
  function parseCSV(data) {
    const lines = data.trim().split("\n"); // CSVデータを行ごとに分割
    const tableBody = document.getElementById("csvBody"); // テーブルボディ要素を取得
    const itemList = document.getElementById("item_list"); // アイテムリストを取得
    const itemCount = document.getElementById("item_count"); // 件数表示部分を取得
  
    // ヘッダーの追加 (登録状況の列を含む)
    const header = document.getElementById("csvHeader");
    header.innerHTML = ""; // ヘッダーをクリア
    const headerRow = document.createElement("tr");
    const columns = lines[0].split(","); // ヘッダー行を分割して取得
  
    // 元のヘッダー列を追加
    columns.forEach((column) => {
      const th = document.createElement("th");
      th.textContent = column.trim();
      headerRow.appendChild(th);
    });
  
    // 登録状況列のヘッダーを追加
    const statusTh = document.createElement("th");
    statusTh.textContent = "登録状況";
    headerRow.appendChild(statusTh);
  
    header.appendChild(headerRow);
  
    // データ行のみを保持
    const dataRows = lines.slice(1);
  
    function renderRows() {
      tableBody.innerHTML = ""; // テーブルボディをクリア
      itemList.style.display = 'block'; // データがある場合にアイテムリストを表示
      itemCount.textContent = dataRows.length; // 読み取り件数を表示
  
      statusCells = []; // 新たにステータスセルリストを初期化
  
      dataRows.forEach((line) => {
        const row = document.createElement("tr"); // 行要素を作成
        const cells = line.split(","); // カンマで分割してセルデータを取得
  
        // 各データセルを追加
        cells.forEach((cell) => {
          const td = document.createElement("td");
          td.textContent = cell.trim();
          row.appendChild(td);
        });
  
        // 登録状況列を追加
        const statusTd = document.createElement("td");
        statusTd.textContent = "未登録"; // デフォルトで「未登録」を表示
        row.appendChild(statusTd);
  
        // 登録状況セルを配列に追加
        statusCells.push(statusTd);
  
        tableBody.appendChild(row); // テーブルボディに行を追加
      });
    }
  
    renderRows();
  
    // 「全て登録」ボタンの処理
    document.getElementById("register_all_button").addEventListener("click", function () {
      statusCells.forEach((statusTd) => {
        statusTd.textContent = "登録済み"; // すべての登録状況を「登録済み」に変更
      });
    });
  }
  