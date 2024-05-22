<x-app-layout>
  {{-- paste the code here --}}
  @php
      $loggedIn_userId = auth()->user()->id;
      $loggedIn_userName = auth()->user()->name;
  @endphp
  <!-- ========== MAIN CONTENT ========== -->
<!-- Breadcrumb -->
<div class="sticky top-0 inset-x-0 z-20 bg-white border-y px-4 sm:px-6 md:px-8 lg:hidden dark:bg-neutral-800 dark:border-neutral-700">
  <div class="flex justify-between items-center py-2">
    <!-- Breadcrumb -->
    <ol class="ms-3 flex items-center whitespace-nowrap">
      <li class="flex items-center text-sm text-gray-800 dark:text-neutral-400">
        Chat App
        <svg class="flex-shrink-0 mx-3 overflow-visible size-2.5 text-gray-400 dark:text-neutral-500" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M5 1L10.6869 7.16086C10.8637 7.35239 10.8637 7.64761 10.6869 7.83914L5 14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
      </li>
      <li class="text-sm font-semibold text-gray-800 truncate dark:text-neutral-400" aria-current="page">
        Dashboard
      </li>
    </ol>
    <!-- End Breadcrumb -->

    <!-- Sidebar -->
    <button type="button" class="py-2 px-3 flex justify-center items-center gap-x-1.5 text-xs rounded-lg border border-gray-200 text-gray-500 hover:text-gray-600 dark:border-neutral-700 dark:text-neutral-400 dark:hover:text-neutral-200" data-hs-overlay="#application-sidebar" aria-controls="application-sidebar" aria-label="Sidebar">
      <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 8L21 12L17 16M3 12H13M3 6H13M3 18H13"/></svg>
      <span class="sr-only">Sidebar</span>
    </button>
    <!-- End Sidebar -->
  </div>
</div>
<!-- End Breadcrumb -->

<!-- Sidebar -->
<div id="application-sidebar" class="hs-overlay [--auto-close:lg]
  hs-overlay-open:translate-x-0
  -translate-x-full transition-all duration-300 transform
  w-[260px]
  hidden
  fixed inset-y-0 start-0 z-[60]
  bg-white border-e border-gray-200
  lg:block lg:translate-x-0 lg:end-auto lg:bottom-0
  dark:bg-neutral-800 dark:border-neutral-700
 ">
  <div class="px-8 pt-4">
    <!-- Logo -->
    <a class="flex-none rounded-xl text-xl inline-block font-semibold focus:outline-none focus:opacity-80" href="/dashboard" aria-label="Preline">
      Chat App
    </a>
    <!-- End Logo -->
  </div>

  <nav class="hs-accordion-group p-6 w-full flex flex-col flex-wrap" data-hs-accordion-always-open>
    <ul class="space-y-1.5" id="user-list">
        @foreach ($all_users as $user)
            <li  data-id="{{$user->id}}" data-name="{{$user->name}}">
                <a class="flex items-center gap-x-3.5 py-2 px-2.5  text-sm text-neutral-700 rounded-lg hover:bg-gray-100 dark:bg-neutral-700 dark:text-white" href="#">
                <img src="https://ui-avatars.com/api/?name={{$user->name}}&rounded=true&background=random" alt="" height="30px" width="30px">
                {{$user->name}}
                </a>
            </li>
        @endforeach
    </ul>
  </nav>
</div>
<!-- End Sidebar -->

<!-- Content -->
<div class="w-full pt-10 px-4 sm:px-6 md:px-8 lg:ps-72">
  <!-- here we create a card ... -->
    <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl p-4 md:p-5 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
        <!-- here messages will be published  -->
        <!-- Chat Bubble -->
        <ul class="space-y-5" id="chat-container">
        <!-- Chat -->
        
        <!-- End Chat -->

        <!-- Chat -->
        
        <!-- End Chat -->

        
        <!-- End Chat Bubble -->
        </ul>
        <!-- End Chat Bubble -->

        {{-- here the input and button --}}
        <div class="relative mt-5">
            <div class="flex">
                <input type="text"  id="msg-input" class="peer py-3 px-4 pr-12 block w-full bg-gray-200 border-transparent rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Enter your message">
                <button type="button" onclick="sendMessage(currentChannel)" class="peer absolute inset-y-0 right-0 flex items-center justify-center bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 text-white font-semibold py-2 px-3 rounded-r-lg shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send-fill" viewBox="0 0 16 16">
                        <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471z"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- End Content -->
<!-- ========== END MAIN CONTENT ========== -->

<script>
   var ably = new Ably.Realtime.Promise({
      key: 'sdqQlA.q7MlCA:6oSUNmCKLiEZB2edOso0QEaZdCJ9DCHFx1R36A2Woxw' //here pass your API key that we created on the ably Account
   });

    // i declare this as global
    var recipientId = null;
    // declare the global currentChannel
    var currentChannel = null;
    var recipientName = null;

  ably.connection.on((stateChange) => {
      console.log(stateChange.current);
  });

  //get the logged in user id
  var login_userId = '<?php echo $loggedIn_userId; ?>';

  // console.log(login_userId);

  // get the list of users
  var UserList = $('#user-list');

  UserList.on('click','li',function(){
    recipientId = $(this).attr('data-id');
    recipientName = $(this).attr('data-name');
    // console.log(recipientName);

    // let's show the selected user by adding a background color
    UserList.find('li').removeClass('selected-user');

    $(this).addClass('selected-user');

    // Perform AJAX call to check if the channel exists in the database
        $.ajax({
            url: '/check-channel',
            method: 'GET',
            data: { recipientId: recipientId },
            success: function (response) {
                if (response.channelExists) {
                    // Channel exists, get the channel name from the response
                    var channelName = response.channelName;

                    // Subscribe to the existing channel
                    subscribeToChannel(channelName); //let's create this function
                } else {
                    // Channel doesn't exist, create a new one
                    createNewChannel(recipientId); //now create this function
                }
            },
            error: function (xhr, status, error) {
                // Handle error
                console.error(error);
            }
        });

  });

// let's add a way to publish a message 
 function sendMessage(currentChannel) {
        // console.log(currentChannel.name);
        var messageInput = document.getElementById('msg-input');
        var message = messageInput.value.trim();

        if (message !== '') { //if empty do not publish
            currentChannel.publish(currentChannel.name, { text: message, sender:'local' });
        
            messageInput.value = '';
        }
    }

  function subscribeToChannel(channelName) {
    // Unsubscribe from the current channel if it exists
    if (currentChannel) {
        currentChannel.unsubscribe();
    }
    // Get the channel for this conversation pair
    currentChannel = ably.channels.get(channelName);
    // console.log(currentChannel);
    currentChannel.subscribe(function (message) {
        displayMessage(message,recipientName); //let's create this function
        // console.log(message.data.text);
    });

    // Show the chat container
    $('#chat-container').html('');
}

function createNewChannel(recipientId) {
    // Perform AJAX call to create a new channel
    $.ajax({
        url: '/create-channel',
        method: 'GET',
        data: { recipientId: recipientId },
        success: function (response) {
            if(response.success == true)
            // Subscribe to the newly created channel
            subscribeToChannel(response.channelName);
            else 
            console.log(response.error);
        },
        
    });
}

function displayMessage(messageObject, recipientName){
    var isLocalSender = messageObject.connectionId == ably.connection.id; //here we want to know which message is from the logged in user
    const chatContainer = $('#chat-container');
    const message1 = `<li class="max-w-lg flex gap-x-2 sm:gap-x-4 me-11">
            <img class="inline-block size-9 rounded-full" src="https://ui-avatars.com/api/?name=${recipientName}&rounded=true&color=grey" alt="Image Description">
            <!-- Card -->
            <div class="bg-white border border-gray-200 rounded-2xl p-4 space-y-3 dark:bg-neutral-900 dark:border-neutral-700">
              <h2 class="font-medium text-gray-800 dark:text-white">
                  ${messageObject.data.text}
              </h2>
            </div>
            <!-- End Card -->
        </li>`;

    const message2 = `<li class="flex ms-auto gap-x-2 sm:gap-x-4">
            <div class="grow text-end space-y-3">
            <!-- Card -->
            <div class="inline-block bg-blue-600 rounded-2xl p-4 shadow-sm">
                <p class="text-sm text-white">
                ${messageObject.data.text}
                </p>
            </div>
            <!-- End Card -->
            </div>

            <span class="flex-shrink-0 inline-flex items-center justify-center size-[50px] rounded-full">
            <span class="text-sm font-medium text-white leading-none">
              <img src="https://ui-avatars.com/api/?name=<?php echo $loggedIn_userName; ?>&rounded=true&background=random" alt="" height="50px" width="50px">
            </span>
            </span>
        </li>`;
        chatContainer.append(isLocalSender == true ? message2 : message1);
}

</script>
</x-app-layout>
