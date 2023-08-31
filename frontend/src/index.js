import React from 'react';
import ReactDOM from 'react-dom/client';
import './index.css';
import App from './App';
import reportWebVitals from './reportWebVitals';
import Page from "./components/Page/Page";
import Counter from "./components/Counter";

const root = ReactDOM.createRoot(document.getElementById('root'));
const arr = [2, 5, 7, 99, 66, 14];
root.render(
    <React.StrictMode>
        <Counter/>
        {arr.map(
            (value, index) =>
                <Counter key={index} value={value} color="yellow"/>
        )}
    </React.StrictMode>
);

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals();
