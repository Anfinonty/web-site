# bot.py
import os
import time
import re
import random
import discord
import asyncio
#import json
from discord.ext import commands,tasks
from dotenv import load_dotenv
from discord import FFmpegPCMAudio, PCMVolumeTransformer
from discord.utils import get
#import yt_dlp as youtube_dl
import youtube_dl
from youtube_dl import YoutubeDL


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
          verse = l[2].strip()

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
      to_say = chapter[0]+":"+VERSE[0]+" "+VERSE[1]
      output.append(to_say)
    else: #verse input
      _V = re.split(r'(\:)',input)
      if len(_V)>1: #verse and chapter
        try:
          to_say=_V[0]+":"+_V[2]+" "+self.Book[_V[0]][_V[2]]
          output.append(to_say)
        except:
          output.append("Sorry, chapter or verse is not found.")
          pass
      else: #chapter only
        try:
          to_say=input+"\n"
          for _verse in self.Book[input]:
            next = input+":"+_verse+" "+self.Book[input][_verse]+"\n"
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
              next = chapter+":"+_verse+" "+self.Book[chapter][_verse]+"\n"
              if (re.search(input,next,re.IGNORECASE)):
                if (len(to_say)+len(next)>2000):
                  output.append(to_say)
                  to_say = next
                else:
                  to_say = to_say + next
          output.append(to_say)
        output.append(":")
    return output


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

@bot.event
async def on_voice_state_update(member, before, after):
  #if not member.id == self.bot.user.id:
    #return
  if before.channel is None:
    voice = after.channel.guild.voice_client
    time = 0
    while True:
      await asyncio.sleep(1)
      time = time + 1
      #print(time)
      if voice.is_playing(): #set time to 0 if song is playing
        time = 0
      if time == 120: #disconnect after 120 seconds
        await voice.disconnect()
      if not voice.is_connected():
        break


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



@bot.command(aliases=['v'], pass_context=True)
async def vlc(ctx, i):
    vlc_commands=["/var/www/html/audio/Music/Streaming/LinkinParkHybridTheory.flac","/var/www/html/audio/Music/Streaming/TCSATHDFW.flac","/var/www/html/audio/Music/Streaming/PENDULUM.flac","/var/www/html/audio/Music/Streaming/TDAGARIM.flac"]
    _msg=["Linkin Park - Hybrid Theory","Limp Bizkit - The Chocolate Starfish and the Hot Dog Flavored Water","Pendulum - Hold Your Color, In Silico, Immersion","Brand New - The Devil And God Are Raging Inside Me"]

    #kill all previous vlc sessions
    try:
      os.system("pkill vlc &")
      await ctx.send("Previous VLC Sessions Ended.");
    except:
      pass

    try:
      i = int(i)
      _vlc = "cvlc -vvv '" + vlc_commands[i] + "' --sout '#transcode{vcodec=none,acodec=flac,ab=128,channels=2,samplerate=44100,scodec=none}:http{access=https,mux=mp3,dst=:8085}' --http-cert '/etc/apache2/ssl_keys/cert1.pem' --http-key '/etc/apache2/ssl_keys/privkey1.pem' &"
      os.system(_vlc)
      await ctx.send("Enter !p to Stream on Voice Chat. Now Streaming: " + _msg[i])
    except Exception as e:
      await ctx.send(e)
      pass


#https://stackoverflow.com/questions/61757011/how-to-create-a-discord-bot-that-streams-online-radio-in-python
@bot.command(aliases=['p', 'pla'])
async def play(ctx):
    if not ctx.message.author.voice:
      await ctx.send("You are not connected to a voice channel.")
      return 0

    channel = ctx.message.author.voice.channel
    try: #check that channel is connected
      player = await channel.connect()
      player.play(FFmpegPCMAudio('https://gdaym8.site:8085'))
      await ctx.send("Now Streaming from https://gdaym8.site:8085");
    except Exception as f:
      await ctx.send("Ending previous streams. Now Streaming from https://gdaym8.site:8085");

      #disconnect and reconnect
      voice_client = ctx.message.guild.voice_client
      if voice_client.is_connected():
        await voice_client.disconnect()
      player = await channel.connect()
      player.play(FFmpegPCMAudio('https://gdaym8.site:8085'))
      pass

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
  voice_client = ctx.message.guild.voice_client
  if voice_client.is_connected():
      await voice_client.disconnect()
  else:
      await ctx.send("The bot is not connected to a voice channel.")
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
!dhammapada <verse or phrase> -- Recites a verse or Searches a phrase from the Dhammapada
!quran <verse or phrase> -- Recites a verse or Searches a phrase from the Quran
!s "<phrase>" -- Says requested phrase
!v <option> -- Begin Stream with VLC
  0 = Hybrid Theory - Linkin Park
  1 = Chocolate Starfish and The Hot Dog Flavoured Water - Limp Bizkit
  2 = Hold Your Colour, In Silico, Immersion - Pendulum
  3 = The Devil And God Are Raging Inside Me - Brand New
!yt <youtube link> -- Join Voice Chat and Play YouTube Video Audio
"""
    await ctx.send(he)


@bot.command(aliases=['s'], pass_context=True)
async def say(ctx, words):
    await ctx.send(words)


#https://stackoverflow.com/questions/66610012/discord-py-streaming-youtube-live-into-voice
@bot.command(name="yt")
async def yt(ctx, url):
    if not ctx.message.author.voice:
      await ctx.send("You are not connected to a voice channel.")
      return 0

    YDL_OPTIONS = {'format': 'bestaudio/best', 'noplaylist':'True'}
    FFMPEG_OPTIONS = {'before_options': '-reconnect 1 -reconnect_streamed 1 -reconnect_delay_max 5', 'options': '-vn'}

   #download video 
    try:
      with YoutubeDL(YDL_OPTIONS) as ydl:
        info = ydl.extract_info(url, download=False)
        I_URL = info['formats'][0]['url']
        title = info.get('title', None)
        await ctx.send("[YT] Now Playing: " + title)
        source = await discord.FFmpegOpusAudio.from_probe(I_URL, **FFMPEG_OPTIONS)
    except Exception as e:
      await ctx.send(e)
      pass


    channel = ctx.message.author.voice.channel
    try:
        player = await channel.connect()
        player.play(source)
    except Exception as e: #music is already queued
      #await ctx.send(e) #+ " Enter !k and repeat the command to play a different song")
      #leave  vc and reconnect
      voice_client = ctx.message.guild.voice_client
      if voice_client.is_connected():
        await voice_client.disconnect()
      try:
        player = await channel.connect()
        player.play(source)
      except Exception as f:
        await ctx.send(f)
        pass
      pass



@bot.command(aliases=['n'])
async def buddy(ctx):
  usernames = []
  for user in list(ctx.guild.members):
    usernames.append(str(user.id))
  rand_int = random.randint(0,len(usernames))
  await ctx.send("<@"+usernames[rand_int]+"> :buddy:")



@bot.command(name='reboot')
async def reboot(ctx):
  try: #disconnect
    voice_client = ctx.message.guild.voice_client
    if voice_client.is_connected():
        await voice_client.disconnect()
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


bot.run(TOKEN)

