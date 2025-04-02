export const linkListMobileTriggers = () => {
  const triggers = Array.from(document.querySelectorAll(".link-list--trigger"));
  triggers.forEach((trigger) => {
    const li = trigger.closest("li");
    trigger.addEventListener("click", (e) => {
      if (li.classList.contains("hovered")) {
        return true;
      }
      triggers.forEach((t) => t.closest("li").classList.remove("hovered"));
      e.preventDefault();
      e.stopPropagation();
      li.classList.toggle("hovered");
    });
  });
};
