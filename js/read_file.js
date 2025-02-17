document.addEventListener("DOMContentLoaded", () => {
  const fileInput = document.getElementById("file-input"); // input要素の取得
  const fileDragArea = document.getElementById("file-drag-area"); // ドラッグエリア
  const fileListContainer = document.createElement("ul"); // ファイル名一覧を表示するためのリスト要素

  // ドラッグエリアの下にリストを追加
  fileDragArea.appendChild(fileListContainer);

  // ファイル選択時のイベント
  fileInput.addEventListener("change", (event) => {
    const files = event.target.files; // 選択されたファイル一覧
    displayFileNames(files, fileListContainer);
  });

  // ファイル名一覧を表示する関数
  function displayFileNames(files, container) {
    container.innerHTML = ""; // リストをクリア

    if (files.length === 0) {
      container.innerHTML = "<li>ファイルが選択されていません。</li>";
      return;
    }

    for (const file of files) {
      const listItem = document.createElement("li");

      // ファイル形式の確認
      if (!file.name.endsWith(".csv")) {
        listItem.textContent = `エラー: 「${file.name}」はCSV形式ではありません。`;
        listItem.style.color = "red";
      } else {
        listItem.textContent = file.name; // ファイル名を表示
      }
      container.appendChild(listItem);
    }
  }

  // 新しい機能の追加: フォーム送信イベントでファイルと操作内容を保存・処理
  const form = document.querySelector("form");

  form.addEventListener("submit", (event) => {
    event.preventDefault(); // フォームのデフォルト動作を防止

    // ラジオボタンの選択値を取得
    const operation = document.querySelector(
      'input[name="file_command"]:checked'
    );
    if (!operation) {
      alert("操作を選択してください");
      return;
    }

    const operationValue = operation.value;

    // ファイルが選択されているか確認
    const file = fileInput.files[0];
    if (!file) {
      alert("ファイルを選択してください");
      return;
    }

    // ファイル形式の確認
    if (!file.name.endsWith(".csv")) {
      alert("エラー: CSV形式のファイルを選択してください。");
      return;
    }

    // ファイル内容を読み取る
    const reader = new FileReader();
    reader.onload = () => {
      const csvContent = reader.result;

      // ローカルストレージに操作内容とCSVデータを保存
      localStorage.setItem("operation", operationValue);
      localStorage.setItem("csvContent", csvContent);

      // 確認画面に遷移
      window.location.href = "uw205_3.html";
    };
    reader.readAsText(file);
  });
});
