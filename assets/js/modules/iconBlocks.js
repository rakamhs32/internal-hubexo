import InView from "./classes/InView";

export const iconBlocks = () => {
  Array.from(document.querySelectorAll(".icon-block")).forEach((iconBlock) => {
    new InView(iconBlock, {});
  });
};
