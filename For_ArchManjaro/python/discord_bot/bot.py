# bot.py
import os
import time
import re
import random
import discord
import asyncio
#import pafy
#import json
from discord.ext import commands,tasks
from dotenv import load_dotenv
from discord import FFmpegPCMAudio, PCMVolumeTransformer
from discord.utils import get
#import yt_dlp as youtube_dl
#import youtube_dl
#from youtube_dl import YoutubeDL
from yt_dlp import YoutubeDL

class BibleKJV:
  book = {}
  book_title=[
"Genesis","Exodus","Leviticus","Numbers","Deuteronomy",
"Joshua","Judges","Ruth","1 Samuel","2 Samuel",

"1 Kings","2 Kings","1 Chronicles","2 Chronicles","Ezra",
"Nehemiah","Esther","Job","Psalms","Proverbs",

"Ecclesiastes","Solomon","Isaiah","Jeremiah","Lamentations",
"Ezekiel","Daniel","Hosea","Joel","Amos",

"Obadiah","Jonah","Micah","Nahum","Habakkuk",
"Zephaniah","Haggai","Zechariah","Malachi","Matthew",

"Mark","Luke","John","Acts","Romans",
"1 Corinthians","2 Corinthians","Galatians","Ephesians","Philippians",

"Colossians","1 Thessalonians","2 Thessalonians","1 Timothy","2 Timothy",
"Titus","Philemon","Hebrews","James","1 Peter",

"2 Peter","1 John","2 John","3 John","Jude",
"Revelation"]


  def __init__(self):
    skip_line=[5068,9123,12005,15977,19168,21329,23598,23902,23904,23906,26892,26894,26896,29345,29347,293499,29345,29347,29349,32241,32243,42245,34961,37633,40756,41671,42963,43605,46190,53793,56267,56269,56271,56966,57332,61806,66736,67217,71804,73189,73876,74130,74615,74697,74860,75241,75416,75604,75806,75932,76684,76908,79970,81941,85266,87803,90914,92110,93323,94088,94514,94869,95153,95402,95647,95772,96090,96320,96440,96500,97370,97687,97976,98163,98506,98552,98597,98684]
    self.book = {}
    line_no = -1
    regex_begin = r'(^1\:1\s)'
    regex_ = r'(\d{1,3}\:\d{1,3})'

    super_line = []
    line_no = 1
    with open('/python/discord_bot/Bible.TXT','r') as f:
      for line in f:
        #if line not in in_book_tile:
        if line_no>299 and line_no<100112 and line_no not in skip_line:
          _l = line.strip()
          l = re.split(regex_,_l)
          super_line.append(l)
        line_no = line_no+1

    chapter = {}
    verse = {}
    current_chapter = ""
    current_verse = ""
    book_no = -1
    C = None
    verse_txt = ""
    for i in super_line:
      for j in i:
        if re.search(regex_,j): #new stanza
          C = re.split(':',j)
      #C[0] is chapter number
      #C[1] is verse number
          if book_no>-1:
            if C[1] != current_verse: #new verse
              verse[current_verse] = verse_txt + "\n"
              current_verse = C[1]
            if C[0] != current_chapter: #new chapter
              chapter[current_chapter] = verse
              verse = {}
              current_chapter = C[0]
          if j == "1:1": #new book
            if book_no>61 and book_no<65: #has only 1 chapter
              chapter["1"] = verse
            if book_no>-1:
              self.book[self.book_title[book_no]] = chapter
            book_no = book_no + 1
            verse = {}
            chapter = {}
            current_verse = "1"
            current_chapter = "1"
          verse_txt = j + " "
        else:
          verse_txt = verse_txt + j + " "

    #final touches
    verse[current_verse] = verse_txt
    chapter[current_chapter] = verse
    self.book["Revelation"] = chapter

  def get(self):
    return self.book

  def search(self, input=None):
    output = []
    if input == None:
      _book = random.choice(list(self.book.items()))
      _chapter = random.choice(list(_book[1].items()))
      _verse = random.choice(list(_chapter[1].items()))
      to_say = "[" + _book[0] + "] " + _verse[1]
      output.append(to_say)
    else:
      _C = re.split(r'(\~)',input)
      try:
        _V = re.split(r'(\:)',_C[2])
        if len(_V)>1: #theres a verse
          try:
            to_say = "[" + _C[0] + "] " + self.book[_C[0]][_V[0]][_V[2]]
            output.append(to_say)
          except:
            output.append("Sorry. Verse is not found")
            pass
        else: #chapter only
          try:
            to_say=input+"\n"
            for _verse in self.book[_C[0]][_V[0]]:
              next = "\n"+self.book[_C[0]][_V[0]][_verse]
              if (len(to_say)+len(next)>2000):
                output.append(to_say)
                to_say = next
              else:
                to_say = to_say + next
            output.append(to_say)
          except: #book only
            if _C[2]=='$': #random
              _chapter = random.choice(list(self.book[_C[0]].items()))
              _verse = random.choice(list(_chapter[1].items()))
              to_say = "[" + _C[0] + "] " + _verse[1]
            elif _C[2]=='': #blank
              to_say="Book: ["+ input+"]\n"
              for _chapter in self.book[_C[0]]:
                for _verse in self.book[_C[0]][_chapter]:
                  next = "\n"+self.book[_C[0]][_chapter][_verse]
                  if (len(to_say)+len(next)>2000):
                    output.append(to_say)
                    to_say = next
                  else:
                    to_say = to_say + next
            else: #search for phrase in  a book
              to_say="Search Results for '"+_C[2]+"' in Book [" +_C[0] + "]: \n"
              for chapter in self.book[_C[0]]:
                for _verse in self.book[_C[0]][chapter]:
                  stanza =  self.book[_C[0]][chapter][_verse]
                  next = "\n["+_C[0]+"] "+stanza
                  if (re.search(_C[2],stanza,re.IGNORECASE)):
                    if (len(to_say)+len(next)>2000):
                      output.append(to_say)
                      to_say = next
                    else:
                      to_say = to_say + next
            output.append(to_say)
            pass
      except:
        to_say="Search Results for '"+input+"': \n"
        for _book in self.book:
          for chapter in self.book[_book]:
            for _verse in self.book[_book][chapter]:
              stanza = self.book[_book][chapter][_verse]
              next = "\n["+_book+"] "+stanza
              if (re.search(input,stanza,re.IGNORECASE)):
                if (len(to_say)+len(next)>2000):
                  output.append(to_say)
                  to_say = next
                else:
                  to_say = to_say + next
        output.append(to_say)
        pass
      output.append("X")
    return output


class Holy:
  Book = None
  def __init__(self, filename):
    self.Book = {}
    with open(filename,'r') as f:
      regex_ = r'(\d{1,3}\|\d{1,3}\|)'
      CHAPTER={}
      saved_chapter="1"
      for line in f:
        l = re.split(regex_, line)
        try:
          V = l[1][:-1].replace("|",":")
          _V = re.split(r'(\:)',V)

          chapter_no = _V[0]
          verse_no = _V[2]
          verse = _V[0]+":"+_V[2]+" "+l[2].strip()

          if (saved_chapter!=chapter_no):
            self.Book[saved_chapter] = CHAPTER
            CHAPTER = {}
            saved_chapter=chapter_no
            CHAPTER[verse_no] = verse
          else:
            CHAPTER[verse_no] = verse
        except:
          self.Book[saved_chapter] = CHAPTER
          break

  def get(self):
    return self.Book

  def search(self, input = None):
    output = []
    if input == None: #no verse input
      chapter = random.choice(list(self.Book.items()))
      VERSE = random.choice(list(chapter[1].items()))
      to_say = VERSE[1]
      output.append(to_say)
    else: #verse input
      _V = re.split(r'(\:)',input)
      if len(_V)>1: #verse and chapter
        try:
          to_say=self.Book[_V[0]][_V[2]]
          output.append(to_say)
        except:
          output.append("Sorry, chapter or verse is not found.")
          pass
      else: #chapter only
        try:
          to_say=input+"\n"
          for _verse in self.Book[input]:
            next = "\n"+self.Book[input][_verse]+"\n"
            if (len(to_say)+len(next)>2000):
              output.append(to_say)
              to_say = next
            else:
              to_say = to_say + next
          output.append(to_say)
        except:
          to_say="Search Results for '"+input+"': \n"
          for chapter in self.Book:
            for _verse in self.Book[chapter]:
              next = "\n"+self.Book[chapter][_verse]+"\n"
              if (re.search(input,next,re.IGNORECASE)):
                if (len(to_say)+len(next)>2000):
                  output.append(to_say)
                  to_say = next
                else:
                  to_say = to_say + next
          output.append(to_say)
        output.append(":")
    return output


Bible = BibleKJV()
Quran = Holy("/python/discord_bot/Quran.txt")
Dhammapada = Holy("/python/discord_bot/Dhammapada.txt")


FFMPEG_OPTIONS = {'before_options': '-reconnect 1 -reconnect_streamed 1 -reconnect_delay_max 5','options': '-vn'}
load_dotenv()
TOKEN = os.getenv('DISCORD_TOKEN')


intents = discord.Intents.all()
intents.messages = True
bot = commands.Bot(command_prefix='!',intents=intents)

@bot.event
async def on_ready():
    print(f'{bot.user} has connected to Discord!')
    check_vc_inactivity.start()

inactive_trackers = {}

@tasks.loop(seconds=10)
async def check_vc_inactivity():
    global inactive_trackers
    for vc in bot.voice_clients:
        guild_id = vc.guild.id

        # Define what "inactive" means to you. Here it means:
        # 1. No other real users are in the channel with the bot OR
        # 2. The bot isn't actively playing audio.
        real_members = [m for m in vc.channel.members if not m.bot]
        is_inactive = len(real_members) == 0 and not vc.is_playing()

        if is_inactive:
            # If it's already being tracked, check if 2 minutes (120 seconds) have passed
            if guild_id in inactive_trackers:
                elapsed = time.time() - inactive_trackers[guild_id]
                if elapsed >= 120:
                    await vc.disconnect()
                    del inactive_trackers[guild_id]
                    print(f"Left empty/inactive VC in guild {guild_id}")
            else:
                # Start tracking the moment it became inactive
                inactive_trackers[guild_id] = time.time()
        else:
            # If the bot became active again (someone joined or music started), reset tracker
            if guild_id in inactive_trackers:
                del inactive_trackers[guild_id]

#@bot.event
#async def on_voice_state_update(member, before, after):
  #if not member.id == self.bot.user.id:
    #return
#  if before.channel is None:
#    try:
#      voice = after.channel.guild.voice_client
#      time = 0
#      while True:
#        await asyncio.sleep(1)
#        time = time + 1
#        #print(time)
#        if voice.is_playing(): #set time to 0 if song is playing
#          time = 0
#        if time == 120: #disconnect after 120 seconds
#          await voice.disconnect(force=True)
#        if not voice.is_connected():
#          break
#    except:
#      pass

#@bot.command(name='join', help='Tells the bot to join the voice channel')
#async def join(ctx):
#    if not ctx.message.author.voice:
#        await ctx.send("{} is not connected to a voice channel".format(ctx.message.author.name))
#        return
#    else:
#        channel = ctx.message.author.voice.channel
#    player = await channel.connect()



#@bot.command(name='q', help='To make the bot leave the voice channel')
#async def q(ctx):
 #   voice_client = ctx.message.guild.voice_client
 #   if voice_client.is_connected():
 #       await voice_client.disconnect()
 #   else:
 #       await ctx.send("The bot is not connected to a voice channel.")


import datetime
import re

# Make sure last_alert_time is initialized somewhere above this, e.g.:
last_alert_time = datetime.datetime.now() - datetime.timedelta(minutes=5)

#2026-07-10
#2026-07-11 note: AI that is free is genuinely retarded don't trust it
@bot.event
async def on_message(message):
    global last_alert_time


    #Check if the specific user is actually in this server
    target_member = message.guild.get_member(248149827030876172)
    if target_member is not None:

        #5 minute cooldown
        now = datetime.datetime.now()
        time_passed = now - last_alert_time
        if time_passed < datetime.timedelta(minutes=5):
          return

        # 1. Ignore bot's own messages
        if message.author == bot.user:
            return

        # Ignore direct messages (DMs)
        if message.guild is None:
            return


        message_content_lower = message.content.lower()

        TARGET_WORDS = [
          "train", "transit", "bus", "buses", "car", "cars", "metro",
          "station", "tram", "transport", "bart", "traffic",
          "drive", "driving", "walkable", "bike", "road", "homeless","rail",
	  "railroad","city","urban"
        ]

        # Smart keyword matching
        is_match = False
        for word in TARGET_WORDS:
        # For single words like "bus", use regex boundaries (\b) so "ambush" doesn't trigger it
            if re.search(rf"\b{word}\b", message_content_lower):
                is_match = True
                break

        if is_match:
            # 4. Update the timestamp and send the alert
            last_alert_time = now
            mention = "<@248149827030876172>"
            await message.channel.send(f"You have alerted the {mention} (o)>")

    # Always process commands at the very end if no return was hit
    await bot.process_commands(message)




@bot.command(aliases=['v'], pass_context=True)
async def vlc(ctx, i):
    vlc_commands=[
	"/var/www/html/audio/Music/Streaming/LinkinParkHybridTheory.mp3",
	"/var/www/html/audio/Music/Streaming/TCSATHDFW.mp3",
	"/var/www/html/audio/Music/Streaming/PENDULUM.mp3",
	"/var/www/html/audio/Music/Streaming/TDAGARIM.mp3",
        "/var/www/html/audio/Music/Streaming/Dark-Angel-by-Timothy-William-Hellem-1985.mp3"
    ]
    _msg=["Linkin Park - Hybrid Theory","Limp Bizkit - The Chocolate Starfish and the Hot Dog Flavored Water","Pendulum - Hold Your Color, In Silico, Immersion","Brand New - The Devil And God Are Raging Inside Me",
          "Timonthy William Hellem - Dark Angel(1985)"]

    #kill all previous vlc sessions
    try:
      os.system("pkill vlc &")
      await ctx.send("Previous VLC Sessions Ended.");
    except:
      pass

    try:
      i = int(i)
#      _vlc = "cvlc -vvv '" + vlc_commands[i] + "' --sout '#transcode{vcodec=none,acodec=flac,ab=128,channels=2,samplerate=44100,scodec=none}:http{access=https,mux=mp3,dst=:8085}' --http-cert '/etc/apache2/ssl_keys/cert.pem' --http-key '/etc/apache2/ssl_keys/privkey.pem' &"
#      _vlc = "cvlc -vvv '" + vlc_commands[i] + "' --sout '#transcode{vcodec=none,acodec=flac,ab=128,channels=2,samplerate=44100,scodec=none}:http{access=http,mux=mp3,dst=:8085}' &"
      _vlc = "cvlc -vvv '" + vlc_commands[i] + "' --sout '#transcode{acodec=mp3,ab=128,channels=2}:http{mux=raw,dst=:8085}' &"
      os.system(_vlc)
      await ctx.send("Enter !p to Stream on Voice Chat. Now Streaming: " + _msg[i])
    except Exception as e:
      await ctx.send(e)
      pass


#https://stackoverflow.com/questions/61757011/how-to-create-a-discord-bot-that-streams-online-radio-in-python
@bot.command(aliases=['p', 'pla'])
async def play(ctx):
    channel = ctx.message.author.voice.channel
    global player
    await ctx.send("Connected to Voice channel; Loading audio stream...")
    player = await channel.connect()
#    source = FFmpegPCMAudio("https://spiderspeed.site:8085", executable="ffmpeg")
    source = FFmpegPCMAudio("http://vlc.spiderspeed.site", executable="ffmpeg")
#    source = FFmpegPCMAudio("http://localhost:8085", executable="ffmpeg")
    player.play(source, after=None)




#@bot.command(aliases=['s', 'sto'])
#async def stop(ctx):
    #global player
#    try:
#        player.stop()
#    except Exception as e:
#        await ctx.send(e)
#        pass


@bot.command(aliases=['kvlc','killvlc'])
async def kv(ctx):
  try:
    os.system("pkill vlc &");
    await ctx.send("All vlc sessions has ended")
  except Exception as e:
    await ctx.send(e)
    pass



@bot.command(aliases=['kill'])
async def k(ctx):
  #try: #try to end all audio sessions
    #os.system("pkill ffmpeg &");
  #except Exception as e:
    #await ctx.send(e)
    #pass

  #leave  vc
  #voice_client = ctx.message.guild.voice_client
  #if voice_client.is_connected():
    #await voice_client.disconnect()



  await ctx.guild.voice_client.disconnect(force=True)
  await ctx.send("Session has ended.")



@bot.command(name='h')
async def h(ctx):
    he = """
G'day m8! Here are some commands I can perform:
!h -- You are here
!k -- Quit the Voice Chat
!kv -- Kill vlc session
!p -- Join Voice Chat and Play Audio Stream
!buddy -- Randomly call out someone here
!reboot -- Reboots the bot, it takes 8 seconds
!bible <book~chapter:verse or phrase> -- Recites parts or Searches a phrase from the Bible
  <book~$> = Recite a random stanza from a book
  <book~<phrase>> = Returns verses with the phrase from a book
  <book~> = Recite entire book
!dhammapada <verse or phrase> -- Recites a verse or Searches a phrase from the Dhammapada
!quran <verse or phrase> -- Recites a verse or Searches a phrase from the Quran
!s "<phrase>" -- Says requested phrase
!v <option> -- Begin Stream with VLC
  0 = Hybrid Theory - Linkin Park
  1 = Chocolate Starfish and The Hot Dog Flavoured Water - Limp Bizkit
  2 = Hold Your Colour, In Silico, Immersion - Pendulum
  3 = The Devil And God Are Raging Inside Me - Brand New
  4 = Dark Angel (1985) - Timothy William Hellem
!yt <youtube link> -- Join Voice Chat and Play YouTube Video Audio

Source Code at https://github.com/Anfinonty/web-site/tree/main/For_ArchManjaro/python/discord_bot/
"""
    await ctx.send(he)


@bot.command(aliases=['s'], pass_context=True)
async def say(ctx, words):
    await ctx.send(words)


#https://stackoverflow.com/questions/66610012/discord-py-streaming-youtube-live-into-voice
#@bot.command(name="yt")
#async def yt(ctx, url):
#    if not ctx.message.author.voice:
#      await ctx.send("You are not connected to a voice channel.")
#      return 0

#    YDL_OPTIONS = {'format': 'bestaudio/best', 'noplaylist':'True'}
#    FFMPEG_OPTIONS = {'before_options': '-reconnect 1 -reconnect_streamed 1 -reconnect_delay_max 5', 'options': '-vn'}

   #download video 
#    try:
#      with YoutubeDL(YDL_OPTIONS) as ydl:
#        info = ydl.extract_info(url, download=False)
#        I_URL = info['formats'][0]['url']
#        title = info.get('title', None)
#        await ctx.send("[YT] Now Playing: " + title)
#        source = await discord.FFmpegOpusAudio.from_probe(I_URL, **FFMPEG_OPTIONS)
#    except Exception as e:
#      await ctx.send(e)
#      pass


#    channel = ctx.message.author.voice.channel
#    try:
#        player = await channel.connect()
#        player.play(source)
#    except Exception as e: #music is already queued
      #await ctx.send(e) #+ " Enter !k and repeat the command to play a different song")
      #leave  vc and reconnect
#      voice_client = ctx.message.guild.voice_client
#      if voice_client.is_connected():
#        await voice_client.disconnect()
#      try:
#        player = await channel.connect()
#        player.play(source)
#      except Exception as f:
#        await ctx.send(f)
#        pass
#      pass


@bot.command(name="yt")
async def yt(ctx, url):
    # 1. Check if the user is in a voice channel
    if not ctx.author.voice:
        await ctx.send("You are not connected to a voice channel.")
        return

    YDL_OPTIONS = {
        'format': 'bestaudio/best',
        'noplaylist': 'True',
        'quiet': True,
        # Forces yt-dlp to pass a highly compatible stream URL
#        'force_generic_extractor': False,
	# Added a standard User-Agent to help prevent YouTube blocking
#	'user_agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'

	'force_generic_extractor': False,
        # Bypasses the broken web player by routing requests through alternative clients
        'extractor_args': {
            'youtube': {
                'player_client': ['android', 'ios']
            }
        }
    }

    FFMPEG_OPTIONS = {
        # Notice we combined the reconnect commands cleanly into one string
        'before_options': '-reconnect 1 -reconnect_streamed 1 -reconnect_delay_max 5', 
        'options': '-vn'
    }

    try:
        with YoutubeDL(YDL_OPTIONS) as ydl:
            info = ydl.extract_info(url, download=False)
            # Some formats return a list of entries, handle cleanly:
            #if 'entries' in info:
            #    info = info['entries'][0]

            I_URL = info['url'] 
            title = info.get('title', 'Unknown Title')

        raw_source = discord.FFmpegPCMAudio(I_URL, **FFMPEG_OPTIONS)
        source = discord.PCMVolumeTransformer(raw_source)

    except Exception as e:
        await ctx.send(f"Error fetching video: {e}")
        return  # Stop execution if we couldn't get the audio source

    # 3. Handle Voice Connection and Playback
    channel = ctx.author.voice.channel
    voice_client = ctx.guild.voice_client

    try:
        # If bot is not in a VC, connect to the user's channel
        if voice_client is None:
            voice_client = await channel.connect()
        # If bot is in a different VC, move to the user's channel
        elif voice_client.channel != channel:
            await voice_client.move_to(channel)

        # If something is already playing, stop it first
        if voice_client.is_playing():
            voice_client.stop()

        # Play the audio
        voice_client.play(source)
        await ctx.send(f"[YT] Now Playing: **{title}**")

    except Exception as e:
        await ctx.send(f"An error occurred while trying to play: {e}")




@bot.command(aliases=['n','nig','buddy','nigga'])
async def nigger(ctx):
  usernames = []
  for user in list(ctx.guild.members):
    usernames.append(str(user.id))
  rand_int = random.randint(0,len(usernames))
  await ctx.send("<@"+usernames[rand_int]+"> https://cdn.discordapp.com/emojis/1130480621391708160.webp?size=32")



@bot.command(name='reboot')
async def reboot(ctx):
  try: #disconnect
    voice_client = ctx.message.guild.voice_client
    if voice_client.is_connected():
        await voice_client.disconnect(force=True)
  except:
    pass

  await ctx.send("All Sessions Ended. Check back 8 seconds later. Rebooting....")
  await ctx.bot.close()
  os.system("pkill ffmpeg && pkill python3 &")
  time.sleep(3)
  #python3 /python/discord_bot/bot.py > pylogs &
  os.system("python3 /python/discord_bot/bot.py &")



@bot.command(aliases=['q','Q','ko','qu','Koran','Ko','Qu','koran','Quran'])
async def quran(ctx, input=None):
  global Quran
  results = Quran.search(input)
  for msg in results:
    await ctx.send(msg)


@bot.command(aliases=['d','D','Dhammapada','Dhamma','dhamma','dh','Dh'])
async def dhammapada(ctx, input=None):
  global Dhammapada
  results = Dhammapada.search(input)
  for msg in results:
    await ctx.send(msg)

@bot.command(aliases=['b','Bible','B'])
async def bible(ctx, input=None):
  global Bible
  results = Bible.search(input)
  for msg in results:
    await ctx.send(msg)

@bot.command(aliases=['Bibble'])
async def bibble(ctx, input=None):
  msg = "https://makeagif.com/gif/aqua-teen-hunger-force-the-bibble-_1UoSi"
  await ctx.send(msg)


bot.run(TOKEN)

