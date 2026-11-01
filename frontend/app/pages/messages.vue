<template>
  <div class="h-screen flex flex-col overflow-hidden bg-background">
    <!-- TopNavBar -->
    <Header />

    <div class="flex flex-1 overflow-hidden">
      <!-- SideNavBar / Conversation List (Left Column) -->
      <aside 
        :class="[
          'flex flex-col w-full md:w-80 bg-surface-container-low border-r border-outline-variant h-full flex-shrink-0 transition-all',
          activeConversationId && isMobile ? 'hidden' : 'flex'
        ]"
      >
        <!-- Header/Search in Sidebar -->
        <div class="p-md border-b border-outline-variant bg-surface-container-lowest">
          <div class="relative">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">search</span>
            <input 
              v-model="searchQuery"
              type="text" 
              placeholder="Search messages..." 
              class="w-full pl-10 pr-sm py-sm rounded-lg border border-outline-variant bg-surface text-on-surface font-body-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-shadow" 
            />
          </div>
        </div>

        <!-- Chat List -->
        <div class="flex-1 overflow-y-auto custom-scrollbar p-sm">
          <div v-if="loadingConversations" class="flex justify-center p-md text-on-surface-variant">
            <span class="material-symbols-outlined animate-spin text-primary">progress_activity</span>
          </div>

          <div v-else-if="filteredConversations.length === 0" class="p-md text-center text-on-surface-variant text-sm">
            No conversations found.
          </div>

          <div 
            v-for="conv in filteredConversations" 
            :key="conv.id"
            @click="selectConversation(conv.id)"
            :class="[
              'flex items-center gap-md p-sm rounded-lg cursor-pointer transition-colors mb-xs',
              activeConversationId === conv.id 
                ? 'bg-secondary-container text-on-secondary-container' 
                : 'hover:bg-surface-variant text-on-surface'
            ]"
          >
            <div class="relative flex-shrink-0">
              <img 
                :src="conv.other_user?.avatar_url || `https://ui-avatars.com/api/?name=${encodeURIComponent(conv.other_user?.name || 'User')}&background=random`" 
                :alt="conv.other_user?.name" 
                class="w-12 h-12 rounded-full object-cover border border-outline-variant" 
              />
              <div 
                v-if="activeConversationId === conv.id"
                class="absolute bottom-0 right-0 w-3 h-3 bg-primary rounded-full border-2 border-secondary-container"
              />
            </div>
            <div class="flex-1 min-w-0">
              <div class="flex justify-between items-baseline mb-xs">
                <h3 class="font-label-md font-semibold truncate">{{ conv.other_user?.name || 'User' }}</h3>
                <span class="font-label-sm opacity-80 text-xs">{{ formatMessageTime(conv.latest_message?.created_at) }}</span>
              </div>
              <p class="font-body-sm truncate opacity-90 text-xs">
                {{ conv.latest_message?.content || 'No messages yet' }}
              </p>
            </div>
            <div v-if="conv.unread_count > 0" class="w-5 h-5 rounded-full bg-primary flex items-center justify-center flex-shrink-0">
              <span class="font-label-sm text-[10px] text-on-primary font-bold leading-none">{{ conv.unread_count }}</span>
            </div>
          </div>
        </div>
      </aside>

      <!-- Main Chat Window (Right Column) -->
      <main 
        :class="[
          'flex-1 flex flex-col bg-surface-container-lowest h-full relative',
          !activeConversationId && isMobile ? 'hidden' : 'flex'
        ]"
      >
        <template v-if="activeConversation">
          <!-- Chat Header -->
          <div class="flex items-center justify-between p-md border-b border-outline-variant bg-surface-container-lowest sticky top-0 z-10 shadow-sm">
            <div class="flex items-center gap-md">
              <button 
                @click="activeConversationId = null" 
                class="md:hidden p-xs text-on-surface-variant hover:text-primary transition-colors"
              >
                <span class="material-symbols-outlined">arrow_back</span>
              </button>
              <div class="relative flex-shrink-0">
                <img 
                  :src="activeConversation.other_user?.avatar_url || `https://ui-avatars.com/api/?name=${encodeURIComponent(activeConversation.other_user?.name || 'User')}&background=random`" 
                  :alt="activeConversation.other_user?.name" 
                  class="w-10 h-10 rounded-full object-cover border border-outline-variant" 
                />
                <div class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-primary rounded-full border border-surface-container-lowest" />
              </div>
              <div>
                <h2 class="font-label-md font-bold text-on-surface">{{ activeConversation.other_user?.name }}</h2>
                <p class="font-label-sm text-primary capitalize text-xs">{{ activeConversation.other_user?.role || 'Member' }} • Active</p>
              </div>
            </div>
            <div class="flex items-center gap-sm">
              <NuxtLink 
                :to="`/room/${activeConversation.id}`" 
                class="p-sm text-on-surface-variant hover:text-primary hover:bg-surface-variant rounded-full transition-colors inline-flex items-center"
                title="Start Video Call"
              >
                <span class="material-symbols-outlined">videocam</span>
              </NuxtLink>
            </div>
          </div>

          <!-- Chat Messages Area -->
          <div ref="messagesContainer" class="flex-1 overflow-y-auto custom-scrollbar p-lg flex flex-col gap-md bg-surface-bright">
            <div v-if="loadingMessages" class="flex justify-center py-lg text-on-surface-variant">
              <span class="material-symbols-outlined animate-spin text-primary">progress_activity</span>
            </div>

            <div v-else-if="messages.length === 0" class="py-xl text-center text-on-surface-variant text-sm">
              Say hello! Start the conversation below.
            </div>

            <template v-else>
              <div 
                v-for="msg in messages" 
                :key="msg.id"
                :class="[
                  'flex items-end gap-sm max-w-[85%] md:max-w-[70%]',
                  isMyMessage(msg) ? 'self-end justify-end mt-sm' : ''
                ]"
              >
                <img 
                  v-if="!isMyMessage(msg)"
                  :src="activeConversation.other_user?.avatar_url || `https://ui-avatars.com/api/?name=${encodeURIComponent(activeConversation.other_user?.name || 'User')}&background=random`" 
                  :alt="activeConversation.other_user?.name" 
                  class="w-8 h-8 rounded-full object-cover border border-outline-variant mb-1 flex-shrink-0" 
                />

                <div :class="['flex flex-col gap-xs', isMyMessage(msg) ? 'items-end w-full' : '']">
                  <span class="font-label-sm text-on-surface-variant text-[11px]" :class="isMyMessage(msg) ? 'mr-1' : 'ml-1'">
                    {{ isMyMessage(msg) ? 'You' : activeConversation.other_user?.name }} • {{ formatMessageTime(msg.created_at) }}
                  </span>
                  <div 
                    :class="[
                      'p-sm rounded-xl font-body-md shadow-sm text-sm break-words',
                      isMyMessage(msg) 
                        ? 'bg-primary text-on-primary rounded-br-sm' 
                        : 'bg-surface-container text-on-surface rounded-bl-sm border border-outline-variant'
                    ]"
                  >
                    {{ msg.content }}
                  </div>
                </div>
              </div>
            </template>
          </div>

          <!-- Chat Input Area -->
          <div class="p-md bg-surface-container-lowest border-t border-outline-variant">
            <div class="flex items-end gap-sm bg-surface rounded-xl border border-outline-variant focus-within:border-primary focus-within:ring-1 focus-within:ring-primary p-xs transition-shadow">
              <textarea 
                v-model="newMessage"
                @keydown.enter.exact.prevent="sendCurrentMessage"
                class="flex-1 max-h-32 min-h-[44px] py-sm px-sm bg-transparent border-none focus:ring-0 resize-none font-body-md text-on-surface placeholder:text-outline-variant custom-scrollbar outline-none text-sm" 
                placeholder="Type a message (Press Enter to send)..." 
                rows="1"
              />
              <div class="flex items-center gap-xs flex-shrink-0 mb-1">
                <button 
                  @click="sendCurrentMessage"
                  :disabled="!newMessage.trim() || sending"
                  class="p-sm bg-primary text-on-primary rounded-lg hover:bg-primary/90 transition-colors shadow-sm flex items-center justify-center disabled:opacity-50"
                >
                  <span class="material-symbols-outlined text-[18px]">send</span>
                </button>
              </div>
            </div>
          </div>
        </template>

        <!-- No conversation selected state (Desktop) -->
        <div v-else class="flex-1 flex flex-col items-center justify-center p-xl text-center bg-surface-bright">
          <div class="w-16 h-16 rounded-full bg-surface-container flex items-center justify-center mb-md text-on-surface-variant">
            <span class="material-symbols-outlined text-3xl">chat</span>
          </div>
          <h2 class="font-headline-md text-on-surface">Select a conversation</h2>
          <p class="font-body-sm text-on-surface-variant mt-xs max-w-sm">
            Choose a contact on the left to start communicating or catch up on your messages.
          </p>
        </div>
      </main>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, watch, nextTick, onMounted, onUnmounted } from 'vue'
import { useRoute } from 'vue-router'
import { useApiClient } from '~/utils/api'
import { useAuthStore } from '~/stores/auth'

definePageMeta({ layout: false })

interface OtherUser {
  id: number
  name: string
  avatar_url?: string
  role: string
}

interface ConversationItem {
  id: number
  last_message_at: string | null
  unread_count: number
  other_user: OtherUser | null
  latest_message?: {
    content: string
    created_at: string
    sender_id: number
  } | null
}

interface MessageItem {
  id: number
  conversation_id: number
  sender_id: number
  content: string
  read_at: string | null
  created_at: string
}

const route = useRoute()
const api = useApiClient()
const authStore = useAuthStore()

const conversations = ref<ConversationItem[]>([])
const activeConversationId = ref<number | null>(null)
const messages = ref<MessageItem[]>([])
const newMessage = ref('')
const searchQuery = ref('')
const loadingConversations = ref(false)
const loadingMessages = ref(false)
const sending = ref(false)
const messagesContainer = ref<HTMLElement | null>(null)
const isMobile = ref(false)

let pollTimer: ReturnType<typeof setInterval> | null = null

const activeConversation = computed(() => {
  return conversations.value.find(c => c.id === activeConversationId.value) || null
})

const filteredConversations = computed(() => {
  if (!searchQuery.value.trim()) return conversations.value
  const q = searchQuery.value.toLowerCase()
  return conversations.value.filter(c => c.other_user?.name?.toLowerCase().includes(q))
})

const isMyMessage = (msg: MessageItem) => {
  return msg.sender_id === authStore.user?.id
}

const formatMessageTime = (iso?: string) => {
  if (!iso) return ''
  const date = new Date(iso)
  return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
}

const scrollToBottom = async () => {
  await nextTick()
  if (messagesContainer.value) {
    messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight
  }
}

const loadConversations = async () => {
  try {
    loadingConversations.value = true
    const res = await api<{ data: ConversationItem[] }>('/conversations')
    conversations.value = res.data || []
  } catch (err) {
    console.error('Failed to load conversations:', err)
  } finally {
    loadingConversations.value = false
  }
}

const loadMessages = async (conversationId: number) => {
  try {
    loadingMessages.value = true
    const res = await api<{ messages: MessageItem[] }>(`/conversations/${conversationId}/messages`)
    messages.value = res.messages || []
    scrollToBottom()

    // Mark conversation unread count locally as 0
    const conv = conversations.value.find(c => c.id === conversationId)
    if (conv) conv.unread_count = 0
  } catch (err) {
    console.error('Failed to load messages:', err)
  } finally {
    loadingMessages.value = false
  }
}

const selectConversation = (id: number) => {
  activeConversationId.value = id
  loadMessages(id)
}

const sendCurrentMessage = async () => {
  const content = newMessage.value.trim()
  if (!content || !activeConversationId.value || sending.value) return

  sending.value = true
  const convId = activeConversationId.value
  newMessage.value = ''

  try {
    const res = await api<{ success: boolean; message: MessageItem }>(`/conversations/${convId}/messages`, {
      method: 'POST',
      body: { content }
    })

    if (res.message) {
      messages.value.push(res.message)
      scrollToBottom()

      // Update latest message in sidebar
      const conv = conversations.value.find(c => c.id === convId)
      if (conv) {
        conv.latest_message = {
          content: res.message.content,
          created_at: res.message.created_at,
          sender_id: res.message.sender_id
        }
      }
    }
  } catch (err) {
    console.error('Failed to send message:', err)
    newMessage.value = content // Restore unsent message
  } finally {
    sending.value = false
  }
}

onMounted(async () => {
  const checkMobile = () => {
    isMobile.value = window.innerWidth < 768
  }
  checkMobile()
  window.addEventListener('resize', checkMobile)

  await loadConversations()

  // Handle query parameter user_id (e.g. from consultant card or booking)
  const targetUserId = route.query.user_id ? Number(route.query.user_id) : null
  if (targetUserId) {
    try {
      const res = await api<{ id: number }>('/conversations/start', {
        method: 'POST',
        body: { user_id: targetUserId }
      })
      if (res?.id) {
        await loadConversations()
        selectConversation(res.id)
      }
    } catch (err) {
      console.error('Failed to start conversation:', err)
    }
  } else if (!isMobile.value) {
    const firstConv = conversations.value[0]
    if (firstConv) {
      selectConversation(firstConv.id)
    }
  }

  // Periodic polling for new messages every 5 seconds
  pollTimer = setInterval(() => {
    if (activeConversationId.value) {
      api<{ messages: MessageItem[] }>(`/conversations/${activeConversationId.value}/messages`)
        .then(res => {
          if (res.messages && res.messages.length > messages.value.length) {
            messages.value = res.messages
            scrollToBottom()
          }
        })
        .catch(() => {})
    }
  }, 5000)
})

onUnmounted(() => {
  if (pollTimer) clearInterval(pollTimer)
})
</script>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background-color: #bccac0;
    border-radius: 20px;
}
</style>
