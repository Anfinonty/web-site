
# bot.py
import os
import random
import discord
from discord.ext import commands,tasks
from dotenv import load_dotenv
from discord import FFmpegPCMAudio, PCMVolumeTransformer
from discord.utils import get
#import yt_dlp as youtube_dl
import youtube_dl
from youtube_dl import YoutubeDL

FFMPEG_OPTIONS = {'before_options': '-reconnect 1 -reconnect_streamed 1 -reconnect_delay_max 5','options': '-vn'}

load_dotenv()
TOKEN = os.getenv('DISCORD_TOKEN')


intents = discord.Intents.all()
#intents.message_content = True
intents.messages = True
#client = discord.Client(intents=intents)
#player = None
#global player
bot = commands.Bot(command_prefix='!',intents=intents)

@bot.event
async def on_ready():
    print(f'{bot.user} has connected to Discord!')



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
    vlc_commands=["/var/www/html/audio/Music/Streaming/LinkinParkHybridTheory.flac","/var/www/html/audio/Music/Limp Bizkit/Chocolate Starfish and the Hot Dog Flavored Water/","/var/www/html/audio/Music/Streaming/PENDULUM.flac"]
    _msg=["Linkin Park - Hybrid Theory","Limp Bizkit - The Chocolate Starfish and the Hot Dog Flavored Water","Pendulum - Hold Your Color, In Silico, Immersion"]

    #kill all previous vlc sessions
    try:
      os.system("pkill vlc &")
      await ctx.send("Previous VLC Sessions Ended.");
      voice_client = ctx.message.guild.voice_client
      if voice_client.is_connected():
        await voice_client.disconnect()
    except:
      pass

    try:
      i = int(i)
      _vlc = "cvlc -vvv '" + vlc_commands[i] + "' --sout '#transcode{vcodec=none,acodec=flac,ab=128,channels=2,samplerate=44100,scodec=none}:http{access=https,mux=mp3,dst=:8085}' --http-cert '/etc/apache2/ssl_keys/cert1.pem' --http-key '/etc/apache2/ssl_keys/privkey1.pem' &"
      os.system(_vlc)
      await ctx.send("Now Streaming: " + _msg[i])
    except Exception as e:
      await ctx.send(e)
      pass


#https://stackoverflow.com/questions/61757011/how-to-create-a-discord-bot-that-streams-online-radio-in-python
@bot.command(aliases=['p', 'pla'])
async def play(ctx):
    try:
      channel = ctx.message.author.voice.channel
      try: #check that channel is connected
        player = await channel.connect()
        player.play(FFmpegPCMAudio('https://gdaym8.site:8085'))
      except Exception as f:
        await ctx.send(f)
        pass
    except Exception as e:
      await ctx.send(e)
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



@bot.command(aliases=['q','kill'])
async def k(ctx):
  try: #try to end all audio sessions
    os.system("pkill ffmpeg &");
  except Exception as e:
    await ctx.send(e)
    pass

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
!k -- Kill current session
!kv -- Kill vlc session
!p -- Join Voice Chat and Play Audio Stream
!q -- Quit the Voice Chat
!buddy
!s "<phrase>" -- Says requested phrase
!v <option> -- Begin Stream with VLC
  0 = Hybrid Theory - Linkin Park
  1 = The Chocolate Starfish and The Hot Dog Flavoured Water - Limp Bizkit
  2 = Pendulum
!yt <youtube link> -- Join Voice Chat and Play YouTube Video Audio
"""
    await ctx.send(he)


@bot.command(aliases=['s'], pass_context=True)
async def say(ctx, words):
    await ctx.send(words)


#https://stackoverflow.com/questions/66610012/discord-py-streaming-youtube-live-into-voice
@bot.command(name="yt")
async def yt(ctx, url):
    YDL_OPTIONS = {'format': 'bestaudio/best', 'noplaylist':'True'}
    FFMPEG_OPTIONS = {'before_options': '-reconnect 1 -reconnect_streamed 1 -reconnect_delay_max 5', 'options': '-vn'}
    try:
      channel = ctx.message.author.voice.channel
      with YoutubeDL(YDL_OPTIONS) as ydl:
        info = ydl.extract_info(url, download=False)
        I_URL = info['formats'][0]['url']
        source = await discord.FFmpegOpusAudio.from_probe(I_URL, **FFMPEG_OPTIONS)
        player = await channel.connect()
        player.play(source)
    except Exception as e: #music is already queued
      await ctx.send("Enter !k and repeat the command to play a different song")
      pass



@bot.command(aliases=['n'])
async def buddy(ctx):
  usernames = []
  for user in list(ctx.guild.members):
    usernames.append(str(user.id))
  rand_int = random.randint(0,len(usernames))
  await ctx.send("<@"+usernames[rand_int]+"> :buddy:")



bot.run(TOKEN)

