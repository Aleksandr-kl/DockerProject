import React from "react";

const GoodsItem = ({good}) => {
console.log(good);
    return <>
        <div>
            <p>{good.name}</p>
        </div>
    </>
}
export default GoodsItem;