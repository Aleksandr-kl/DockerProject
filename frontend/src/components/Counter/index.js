// import {useState} from "react";
// import PropTypes from "prop-types";
//
// function Counter({value = 0, padding = 20, color}) {
//     const [currentValue, setValue] = useState(value)
//     return <div style={{padding, background: color}}>
//         <div>Value: {currentValue}</div>
//         <button onClick={() => {
//             setValue(currentValue + 1)
//         }}>button +
//         </button>
//         <button onClick={() => {
//             setValue(currentValue - 1)
//         }}>button -
//         </button>
//     </div>
// }
//
// // Counter.defaultProps={
// //     value:10
// // }
//
// export default Counter;

import React, {useState, useEffect} from "react";
import PropTypes from "prop-types";

function Counter({value = 5, padding = 20, min = -Infinity, max = Infinity}) {
    const [currentValue, setValue] = useState(value);

    const [color, setColor] = useState("green");

    useEffect(() => {
        if (currentValue <= min || currentValue >= max) {
            setColor("red");

        } else if (currentValue === min + 1 || currentValue === max - 1) {
            setColor("yellow");

        } else {
            setColor("green");
        }

    }, [currentValue, min, max]);

    return (
        <div style={{padding, background: color}}>
            <div>Value: {currentValue}</div>

            <button onClick={() => {
                setValue(currentValue - 1)
            }}>button -
            </button>

            <button onClick={() => {
                setValue(currentValue + 1)
            }}>button -
            </button>
        </div>
    );
}

Counter.propTypes = {
    value: PropTypes.number,
    padding: PropTypes.number,
    min: PropTypes.number,
    max: PropTypes.number,
};

export default Counter;
