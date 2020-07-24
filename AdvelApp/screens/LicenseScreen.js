import * as React from 'react';
import {
    SafeAreaView,
    StatusBar,
    StyleSheet,
    Text
} from 'react-native';

import Button from '../components/Button';


const LicenseScreen = (props: any) => {

    return (
        <>
            <StatusBar barStyle="dark-content" />
            <SafeAreaView style={styles.body}>
                <Text>
                    BSD 2-Clause License
                </Text>
                <Text>
                    Copyright (c) 2020, Fermicoding Internet inženjering DOO, Novi Sad All rights reserved.
                </Text>
                <Text>
                    Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:
                </Text>
                <Text>
                    1. Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
                </Text>
                <Text>
                    2. Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
                </Text>
                <Text>
                    THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
                </Text>
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
});

export default LicenseScreen;


