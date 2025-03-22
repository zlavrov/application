import React, { useState } from 'react';

import List from '@mui/material/List';
import ListItem from '@mui/material/ListItem';
import ListItemText from '@mui/material/ListItemText';
import CommentIcon from '@mui/icons-material/Comment';
import IconButton from '@mui/material/IconButton';
import TextField from '@mui/material/TextField';
import Button from '@mui/material/Button';

function Main() {

    const [messages, setMessages] = useState([]);
    const [message, setMessage] = useState('');

    const handleMessages = () => {

        if (message !== '') {
            const oldMessages = [...messages];
            oldMessages.push(message);
            setMessages(oldMessages);
            setMessage('');
        }
    }

    const handleMessage = (event) => {

        setMessage(event.target.value);
    }

    return (
        <div className="container">

            <div className="col-md-5 col-lg-4 order-md-last">

                <List sx={{ width: '100%', maxWidth: 360, bgcolor: 'background.paper' }}>
                    {
                        messages.map((value, key) => (
                            <ListItem key={key}>
                                <ListItemText primary={value} />
                            </ListItem>
                        ))
                    }
                </List>

                <TextField autoFocus fullWidth onChange={(event) => {handleMessage(event);}} value={message} variant="standard" />
                <Button fullWidth onClick={(event) => {handleMessages()}} variant="outlined">Outlined</Button>

            </div>
        </div>
    );
}

export default Main;
