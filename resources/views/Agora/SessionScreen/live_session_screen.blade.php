<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Live Session</title>
  <script src="https://download.agora.io/edu-apaas/release/edu_sdk_1.1.5.10.js"></script>
</head>

<body>
  <style>
    #root1 {
      width: 100%;
      height: 100%;
    }
  </style>
  <h1>Works</h1>
  <div id="root1"></div>
  <script type="text/javascript">
      
        let path = "{{ route('generate-token') }}";
        fetch(path, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
        }).then((response) => response.json()).then((data) => {
            console.log(data);
            AgoraEduSDK.config({
           // Here pass in the Agora App ID you have got
           appId: data.appId,
           })
    AgoraEduSDK.launch(
      document.querySelector("#root1"), {
        // Here pass in the RTM token you have generated
        rtmToken: data.token,
        // The user ID must be the same as the one you used for generating the RTM token
        userUuid: data.uid,
        userName: data.rolename,
        roomUuid: data.roomid,
        roomName: data.channel,
        roleType: data.role,
        roomType: 0,
        pretest: true,
        language: "en",
        startTime: new Date().getTime(),
        duration: data.duration,
        courseWareList: [],
        listener: (evt) => {
          console.log("evt", evt)
        }
      }
    )
        });
  </script>
</body>

</html>

