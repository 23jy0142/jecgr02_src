document.addEventListener("DOMContentLoaded", () => {
    // ローカルストレージから操作内容とCSVデータを取得
    const operation = localStorage.getItem("operation");
    const csvContent = localStorage.getItem("csvContent");
  
    // #operation_text のテキストを操作内容に応じて変更
    const operationText = document.getElementById("operation_text");
    switch (operation) {
      case "insert":
        operationText.textContent =
          "下記ファイルの内容を支店DBに登録してもよろしいでしょうか？";
        break;
      case "update":
        operationText.textContent =
          "下記ファイルの内容を支店DBに更新してもよろしいでしょうか？";
        break;
      case "delete":
        operationText.textContent =
          "下記ファイルの商品情報を支店DBから削除してもよろしいでしょうか？";
        break;
      default:
        operationText.textContent = "操作が不明です。";
    }
  
    // CSVデータをテーブルに表示
    const table = document.querySelector(".read_file_list table");
  
    if (csvContent) {
      const rows = csvContent.trim().split("\n");
  
      // CSVデータを行ごとに処理
      rows.forEach((row, index) => {
        const tr = document.createElement("tr");
  
        // カンマでセルを分割
        const cells = row.split(",");
        cells.forEach((cell) => {
          const td = document.createElement(index === 0 ? "th" : "td");
          td.textContent = cell.trim();
          tr.appendChild(td);
        });
  
        table.appendChild(tr);
      });
    } else {
      alert("CSVデータが見つかりません。");
    }
  });
  