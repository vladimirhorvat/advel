import * as React from 'react';
import {
    SafeAreaView,
    StatusBar,
    StyleSheet,
} from 'react-native';

import Button from '../components/Button';


const HomeScreen = (props: any) => {

    return (
        <>
            <StatusBar barStyle="dark-content" />
            <SafeAreaView style={styles.body}>
                <Button navigate={{screen: 'MapScreen'}} container={styles.container} touch={styles.touch} textStyle={styles.text} text='Open Map' />
                <Button navigate={{screen: 'LicenseScreen'}} container={styles.container} touch={styles.touch} textStyle={styles.text} text='Licence' />
            </SafeAreaView>
        </>
    );
};

const styles = StyleSheet.create({
    body: {
      flex: 1,
      justifyContent: 'center',
      alignItems: 'center',
    },
    container: {
      justifyContent: 'center',
      alignItems: 'center',
      width: 200,
      height: '10%',
      marginBottom: 10,
    },
    touch: {
      backgroundColor: 'black',
      flex: 1,
      width: '100%',
      justifyContent: 'center',
      alignItems: 'center',
    },
    text: {
      fontSize: 18,
      color: 'white',
    },
  });

export default HomeScreen;


