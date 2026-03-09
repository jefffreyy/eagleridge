<!DOCTYPE html>
<html>
  <head>
    <title>Gmail API Quickstart</title>
    <meta charset="utf-8" />
  </head>
  <body>
    <p>Gmail API Quickstart</p>

    <!--Add buttons to initiate auth sequence and sign out-->
    <button id="authorize_button" onclick="handleAuthClick()">Authorize</button>
    <button id="signout_button" onclick="handleSignoutClick()">Sign Out</button>

    <pre id="content" style="white-space: pre-wrap;"></pre>

    <script src="https://smtpjs.com/v3/smtp.js"></script>
    <script>
        const { google } = require('googleapis');
        const { Base64 } = require('js-base64');
        const { createReadStream } = require('fs');
        const { GoogleAuth } = require('google-auth-library');
        
        async function sendEmail(fromEmailAddress, toEmailAddress) {
          try {
            const auth = new GoogleAuth({
              keyFile: 'path_to_your_service_account_json_file', // Path to your service account JSON file
              scopes: ['https://www.googleapis.com/auth/gmail.send'],
            });
            const client = await auth.getClient();
        
            const gmail = google.gmail({
              version: 'v1',
              auth: client,
            });
        
            // ... (rest of the code remains the same)
          } catch (error) {
            if (error instanceof Error) {
              throw new Error('Unable to send message: ' + error.message);
            } else {
              throw error;
            }
          }
        }
    </script>
  </body>
</html>