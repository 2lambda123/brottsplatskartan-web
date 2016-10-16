:root {
    --color-grey-light: #ddd;
    --color-link: #0379C4;
    --default-margin: 1rem;
    --default-margin-half: calc(var(--default-margin)/2);
}

html, body {
    background: white;
    font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;
    /*font-family: sans-serif;*/
    font-weight: normal;
    font-size: 16px;
    line-height: 1.4;
}

body {
    padding-top: 100px;
    /*background: #fafafa;*/
    background: #f4f4f7;
}

h1, h2, h3, h4 {
    font-weight: normal;
    font-weight: 300;
}

h1, h2, h3, h4, ul, ol {
    margin-top: var(--default-margin);
    margin-bottom: var(--default-margin);
}

a {
    color: var(--color-link);
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

.container {
    margin: 0 auto;
    max-width: 1000px;
    padding: 0 10px;
}

.SiteHeader {
    background: #fff;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 5;
    padding: var(--default-margin);
    box-shadow: 2px 1px 1px rgba(0,0,0,0.15);
    font-size: .75rem;

    /* from http://uigradients.com/ */
    background: #fceabb; /* fallback for old browsers */
    background: -webkit-linear-gradient(to left, #fceabb , #f8b500); /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(to left, #fceabb , #f8b500); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

}

.SiteTitle {
    margin: 0;
    line-height: 1;
    text-transform: uppercase;
}

.SiteTagline {
    margin-top: .5em;
    margin-bottom: 0;
    font-style:normal;
}
.SiteTagline em {
    font-style: inherit;
}

.SiteTitle a {
    text-decoration: none;
    color: inherit;
}

.Event {
    margin-top: 2rem;
    margin-bottom: 2rem;
    background: white;
    padding: var(--default-margin);
    box-shadow: 0 1px 2px rgba(0,0,0,.3);
}

.Event__title {
    line-height: 1;
    margin-top: var(--default-margin);
    margin-bottom: .25rem;
}

.Event__date {
    /*margin-bottom: .75rem;*/
    margin-top: .75rem;
}

.Event__location {
    /*color: #999;*/
    /*margin-bottom: .25rem;*/
    margin-bottom: .75rem;
}

.Event__date,
.Event__location {
    /*font-size: .8rem;*/
}

.Event__meta {
    line-height: 1.3;
    margin-top: .75rem;
    margin-bottom: .75rem;
    padding-bottom: .75rem;
    border-bottom: 1px solid var(--color-grey-light);
    margin-left: -1rem;
    margin-right: -1rem;
    padding-left: 1rem;
    font-size: 0.9rem;
    color: #666;
}

.Event__metaDivider {
    color: var(--color-grey-light);
    margin-left: .25rem;
    margin-right: .25rem;
    /*-webkit-font-smoothing: none;*/
}

.Event__dateHuman {
    white-space: nowrap;
}

.Event__dateFormatted {
}

.Event--single .Event__title {
    font-size: 2.25rem;
}


.Event__teaser {
    font-weight: bold;
    margin-top: 0;
    margin-bottom: var(--default-margin-half);
}

.Event__content {
    overflow: hidden;
    position: relative;
    margin-bottom: 0;
}

/* emulate p tags using br */
.Event__content br {
    line-height: 2;
}

.Event__share {
    margin-top: var(--default-margin);
    border-top: 1px solid var(--color-grey-light);
    margin-left: -1rem;
    margin-right: -1rem;
    padding-left: 1rem;
    padding-top: 1rem;
}

amp-social-share {
    margin-right: .25rem;
}

/*
.Event__content {
    max-height: 5rem;
}
.Event__content:after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 2rem;
    background: linear-gradient( rgba(255, 255, 255, 0), white)
}
*/

.Event__map {
    margin-top: -1rem;
    margin-left: -1rem;
    margin-right: -1rem;
    line-height: 1;
    display: block;
}

.pagination {
    text-align: center;
    width: 100%;
    line-height: 1;
    margin: 0;
    padding: 0;
}
.pagination li {
    display: inline-block;
}

.pagination li > a,
.pagination li > span {
    display: block;
    padding: .25em;
}
.pagination li > span {
    font-weight: bold;
}
.pagination li > a:hover {
    background: #ccc;
}

.LanListing {
    overflow: hidden;
}

.LanListing__lan {
    width: 50%;
    float: left;
    font-size: 1rem;
    padding-top: var(--default-margin);
    padding-bottom: var(--default-margin);
    margin: 0;
}

.SiteFooter {
    background: var(--color-grey-light);
    padding: .5rem;
    margin-top: var(--default-margin);
}
