<?php
namespace Magento\AcceptanceTest\_SecureStorefrontURLSuite\Backend;

use Magento\FunctionalTestingFramework\AcceptanceTester;
use \Codeception\Util\Locator;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;
use Yandex\Allure\Adapter\Annotation\Description;
use Yandex\Allure\Adapter\Annotation\Parameter;
use Yandex\Allure\Adapter\Annotation\Severity;
use Yandex\Allure\Adapter\Model\SeverityLevel;
use Yandex\Allure\Adapter\Annotation\TestCaseId;

/**
 * @Title("MC-36900: Verify Storefront Cookie Secure Config over https")
 * @Description("Verify that cookie are secure on storefront over https<h3>Test files</h3>app/code/Magento/Cookie/Test/Mftf/Test/StorefrontVerifySecureCookieTest.xml<br>")
 * @TestCaseId("MC-36900")
 * @group cookie
 * @group configuration
 * @group secure_storefront_url
 */
class StorefrontVerifySecureCookieTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->amOnPage("/"); // stepKey: goToHomePage
		$hostname = $I->executeJS("return window.location.host"); // stepKey: hostname
		$setUnsecureBaseURL = $I->magentoCLI("config:set web/unsecure/base_url https://{$hostname}/", 60); // stepKey: setUnsecureBaseURL
		$I->comment($setUnsecureBaseURL);
		$setSecureBaseURL = $I->magentoCLI("config:set web/secure/base_url https://{$hostname}/", 60); // stepKey: setSecureBaseURL
		$I->comment($setSecureBaseURL);
		$useSecureURLsOnStorefront = $I->magentoCLI("config:set web/secure/use_in_frontend 1", 60); // stepKey: useSecureURLsOnStorefront
		$I->comment($useSecureURLsOnStorefront);
		$I->comment("Entering Action Group [flushCache] CliCacheFlushActionGroup");
		$flushSpecifiedCacheFlushCache = $I->magentoCLI("cache:flush", 60, "full_page"); // stepKey: flushSpecifiedCacheFlushCache
		$I->comment($flushSpecifiedCacheFlushCache);
		$I->comment("Exiting Action Group [flushCache] CliCacheFlushActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->amOnPage("/"); // stepKey: goToHomePage
		$hostname = $I->executeJS("return window.location.host"); // stepKey: hostname
		$setUnsecureBaseURL = $I->magentoCLI("config:set web/unsecure/base_url http://{$hostname}/", 60); // stepKey: setUnsecureBaseURL
		$I->comment($setUnsecureBaseURL);
		$setSecureBaseURL = $I->magentoCLI("config:set web/secure/base_url http://{$hostname}/", 60); // stepKey: setSecureBaseURL
		$I->comment($setSecureBaseURL);
		$useSecureURLsOnStorefront = $I->magentoCLI("config:set web/secure/use_in_frontend 0", 60); // stepKey: useSecureURLsOnStorefront
		$I->comment($useSecureURLsOnStorefront);
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _failed(AcceptanceTester $I)
	{
		$I->saveScreenshot(); // stepKey: saveScreenshot
	}

	/**
	 * @Features({"Cookie"})
	 * @Stories({"Storefront Secure Cookie"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontVerifySecureCookieTest(AcceptanceTester $I)
	{
		$I->amOnPage("/"); // stepKey: goToHomePage
		$isCookieSecure = $I->executeJS("return window.cookiesConfig.secure ? 'true' : 'false'"); // stepKey: isCookieSecure
		$I->assertEquals("true", $isCookieSecure); // stepKey: assertCookieIsSecure
		$isCookieSecure2 = $I->executeJS("return jQuery.mage.cookies.defaults.secure ? 'true' : 'false'"); // stepKey: isCookieSecure2
		$I->assertEquals("true", $isCookieSecure2); // stepKey: assertCookieIsSecure2
	}
}
