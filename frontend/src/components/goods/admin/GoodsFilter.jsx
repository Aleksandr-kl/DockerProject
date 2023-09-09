import React from "react";
import { TextField, Typography } from "@mui/material";

const GoodsFilter = ({filterData, setFilterData}) => {

    const onChangeFilterData = (event) => {
        event.preventDefault();

        let {name, value} = event.target;
        setFilterData({...filterData, [name]: value});

    };

    return <>
        <div className="filter">
            <div className="filter__header">
                <Typography variant="h6" component="h6" mb={1}>
                    Filter
                </Typography>
            </div>
            <TextField
                   type="text"
                   label="Name"
                   name="name"
                   defaultValue={filterData.name ?? ""}
                   onChange={onChangeFilterData}
            />
        </div>
    </>
}
export default GoodsFilter;