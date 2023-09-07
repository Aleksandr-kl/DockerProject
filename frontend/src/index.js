import React from 'react';
import ReactDOM from 'react-dom/client';
import './index.css';
import App from './App';
import reportWebVitals from './reportWebVitals';
import Page from "./components/Page/Page";
import Counter from "./components/Counter";
import {BrowserRouter, Router} from "react-router-dom";


const root = ReactDOM.createRoot(document.getElementById('root'));
const arr = [-11, 5, 7, 11, -7, 15];
root.render(
    <React.StrictMode>
        <BrowserRouter>
            <App/>
            {arr.map(
                (value, index) =>
                    <Counter key={index} value={value} min={-10} max={15}/>
            )}
        </BrowserRouter>
    </React.StrictMode>
);

reportWebVitals();
