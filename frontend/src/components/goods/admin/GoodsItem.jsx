import React from "react";
import {Paper, Table, TableBody, TableCell, TableContainer, TableHead, TableRow} from "@mui/material";


const GoodsItem = ({good}) => {
    return (
        <TableContainer component={Paper}>
            <Table sx={{minWidth: 100}} aria-label="simple table">
                <TableBody>
                    <TableRow>
                        <TableCell align="left">{good.name}</TableCell>
                        <TableCell align="center">{good.count}</TableCell>
                        <TableCell align="right">{good.price}</TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </TableContainer>
    );
}
export default GoodsItem;