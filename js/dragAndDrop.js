export function initDragAndDrop(dragAreaId, fileInputId) {
  // DOM要素を取得
  const dragArea = document.getElementById(dragAreaId);
  const fileInput = document.getElementById(fileInputId);

  // ドラッグオーバー時の処理
  dragArea.addEventListener("dragover", (e) => {
    e.preventDefault();
    dragArea.classList.add("dragging");
  });

  // ドラッグを離した時の処理
  dragArea.addEventListener("dragleave", (e) => {
    e.preventDefault();
    dragArea.classList.remove("dragging");
  });

  // ドロップ時の処理
  dragArea.addEventListener("drop", (e) => {
    e.preventDefault();
    dragArea.classList.remove("dragging");

    // ドロップされたファイルを取得してファイル入力にセット
    const files = e.dataTransfer.files;
    fileInput.files = files;

    console.log("Dropped files:", files);
  });

  // **クリック時にファイル選択ダイアログを開く**
  dragArea.addEventListener("click", () => {
    fileInput.click(); // ファイル入力要素をトリガー
  });

  // ファイル選択時の処理
  fileInput.addEventListener("change", (e) => {
    const files = e.target.files;
    console.log("Selected files via input:", files);
  });
}
