
//swoole的平滑重启
# sh reload.sh

echo 'loading'
pid='pidof live_master'
echo $pid
kill -USR1 $pid
echo 'loading success'