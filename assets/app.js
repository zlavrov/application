// import { registerReactControllerComponents } from '@symfony/ux-react';
// import './bootstrap.js';
// /*
//  * Welcome to your app's main JavaScript file!
//  *
//  * We recommend including the built version of this JavaScript file
//  * (and its CSS file) in your base layout (base.html.twig).
//  */

// // any CSS you import will output into a single css file (app.css in this case)
// import './styles/app.css';

// registerReactControllerComponents(require.context('./react/controllers', true, /\.(j|t)sx?$/));

import React from 'react';
import ReactDOM from 'react-dom/client';
// import { Suspense, StrictMode } from 'react';

// import { HelmetProvider } from 'react-helmet-async';

import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
// import 'bootstrap-icons/font/bootstrap-icons.css';

// import { BrowserRouter, Route } from 'react-router-dom';
// import './styles/app.css';
import Main from './views/Main';

const root = ReactDOM.createRoot(document.getElementById('root'));

root.render(<Main />);