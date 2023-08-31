import {useState} from "react";
import PropTypes from "prop-types";

function Counter({value = 0, padding=20, color}) {
    const [currentValue, setValue] = useState(value)
    return <div style={{padding, background:color}}>
        <div>Value: {currentValue}</div>
        <button onClick={() => {
            setValue(currentValue + 1)
        }}>button+
        </button>
        <button onClick={() => {
            setValue(currentValue - 1)
        }}>button-
        </button>
    </div>
}

// Counter.defaultProps={
//     value:10
// }

export default Counter;