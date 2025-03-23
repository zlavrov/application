import React, { useEffect, useState } from 'react';

import List from '@mui/material/List';
import ListItem from '@mui/material/ListItem';
import ListItemText from '@mui/material/ListItemText';
import CommentIcon from '@mui/icons-material/Comment';
import IconButton from '@mui/material/IconButton';
import TextField from '@mui/material/TextField';
import Button from '@mui/material/Button';
import axips from 'axios';

function Main() {

    const [messages, setMessages] = useState([]);
    const [message, setMessage] = useState('');

    const reloadCoomets = () => {
        axips.get('/api/v1/comments').then((result) => {
            setMessages(result.data);
        });
    };

    useEffect(() => {

        const url = new URL("http://127.0.0.1:3000/.well-known/mercure");
        url.searchParams.append("topic", "/comments");
        url.searchParams.append("token", 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJtZXJjdXJlIjp7InB1Ymxpc2giOlsiKiJdLCJzdWJzY3JpYmUiOlsiKiJdfX0.2mUHXx1pvQsAHiIlCZYdp-5-F8EFN0tyrzw8KdNnnQk'); // 🔥 Додаємо токен у URL
  
        console.log("Mercure URL:", url.toString()); 

        const eventSource = new EventSource(url);
  
        eventSource.onmessage = (event) => {
          const newComment = JSON.parse(event.data);
          setMessages((prev) => [...prev, newComment]);
        };
  
        return () => eventSource.close();

      }, []);

    useEffect(() => {
        reloadCoomets();
    }, []);

    const handleMessages = () => {

        if (message !== '') {
            setMessage('');

            axips.post('http://192.168.0.103:8080/api/v1/comments', {content: message}).then((result) => {
                reloadCoomets();
            });
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
                        messages.map((message, key) => (
                            <ListItem key={key}>
                                <ListItemText primary={message.id + ' - ' + message.content} />
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
