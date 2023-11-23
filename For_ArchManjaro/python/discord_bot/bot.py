# bot.py
import os
import random
import discord
from discord.ext import commands,tasks
from dotenv import load_dotenv
from discord import FFmpegPCMAudio, PCMVolumeTransformer


FFMPEG_OPTIONS = {'before_options': '-reconnect 1 -reconnect_streamed 1 -reconnect_delay_max 5','options': '-vn'}

load_dotenv()
TOKEN = os.getenv('DISCORD_TOKEN')


intents = discord.Intents.all()
#intents.message_content = True
intents.messages = True
#client = discord.Client(intents=intents)
bot = commands.Bot(command_prefix='!',intents=intents)

@bot.event
async def on_ready():
    print(f'{bot.user} has connected to Discord!')


#@client.event
#async def on_message(message):
#    if message.author == client.user:
#      return

#    m8_li = ['gday m8!','summer\'s lovely innit m8']

#    if message.content == 'm8say':
#      response = random.choice(m8_li)
#      await message.channel.send(response)


@bot.command(name='join', help='Tells the bot to join the voice channel')
async def join(ctx):
    if not ctx.message.author.voice:
        await ctx.send("{} is not connected to a voice channel".format(ctx.message.author.name))
        return
    else:
        channel = ctx.message.author.voice.channel
    await channel.connect()



@bot.command(name='leave', help='To make the bot leave the voice channel')
async def leave(ctx):
    voice_client = ctx.message.guild.voice_client
    if voice_client.is_connected():
        await voice_client.disconnect()
    else:
        await ctx.send("The bot is not connected to a voice channel.")



#https://stackoverflow.com/questions/61757011/how-to-create-a-discord-bot-that-streams-online-radio-in-python
@bot.command(aliases=['p', 'pla'])
async def play(ctx, url: str = 'https://gdaym8.site:8085'):
    channel = ctx.message.author.voice.channel
    global player
    try:
        player = await channel.connect()
    except:
        pass
    player.play(FFmpegPCMAudio('https://gdaym8.site:8085'))



@bot.command(aliases=['s', 'sto'])
async def stop(ctx):
    player.stop()


#client.run(TOKEN)
bot.run(TOKEN)
