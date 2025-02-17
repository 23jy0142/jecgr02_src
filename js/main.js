import { initDragAndDrop } from "./components/dragAndDrop.js";

// 初期化処理
document.addEventListener("DOMContentLoaded", () => {
  initDragAndDrop("file-drag-area", "file-input");
});
