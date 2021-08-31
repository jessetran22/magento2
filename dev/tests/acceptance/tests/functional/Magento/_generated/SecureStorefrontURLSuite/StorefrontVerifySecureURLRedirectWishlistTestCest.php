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
 * @Title("MC-15543: Verify Secure URLs For Storefront Wishlist Pages")
 * @Description("Verify that the Secure URL configuration applies to the Wishlist pages on the Storefront<h3>Test files</h3>app/code/Magento/Wishlist/Test/Mftf/Test/StorefrontVerifySecureURLRedirectWishlistTest.xml<br>")
 * @TestCaseId("MC-15543")
 * @group wishlist
 * @group configuration
 * @group secure_storefront_url
 */
class StorefrontVerifySecureURLRedirectWishlistTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("customer", "hook", "Simple_US_Customer", [], []); // stepKey: customer
		$I->comment("Entering Action Group [loginToStorefront] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginToStorefront
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginToStorefront
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginToStorefront
		$I->fillField("#email", $I->retrieveEntityField('customer', 'email', 'hook')); // stepKey: fillEmailLoginToStorefront
		$I->fillField("#pass", $I->retrieveEntityField('customer', 'password', 'hook')); // stepKey: fillPasswordLoginToStorefront
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginToStorefront
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginToStorefrontWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginToStorefront
		$I->comment("Exiting Action Group [loginToStorefront] LoginToStorefrontActionGroup");
		$hostname = $I->executeJS("return window.location.host"); // stepKey: hostname
		$setSecureBaseURL = $I->magentoCLI("config:set web/secure/base_url https://{$hostname}/", 60); // stepKey: setSecureBaseURL
		$I->comment($setSecureBaseURL);
		$useSecureURLsOnStorefront = $I->magentoCLI("config:set web/secure/use_in_frontend 1", 60); // stepKey: useSecureURLsOnStorefront
		$I->comment($useSecureURLsOnStorefront);
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$dontUseSecureURLsOnStorefront = $I->magentoCLI("config:set web/secure/use_in_frontend 0", 60); // stepKey: dontUseSecureURLsOnStorefront
		$I->comment($dontUseSecureURLsOnStorefront);
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->deleteEntity("customer", "hook"); // stepKey: deleteCustomer
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
	 * @Features({"Wishlist"})
	 * @Stories({"Storefront Secure URLs"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontVerifySecureURLRedirectWishlistTest(AcceptanceTester $I)
	{
		$hostname = $I->executeJS("return window.location.host"); // stepKey: hostname
		$I->amOnUrl("http://{$hostname}/wishlist"); // stepKey: goToUnsecureWishlistURL
		$I->seeCurrentUrlEquals("https://{$hostname}/wishlist"); // stepKey: seeSecureWishlistURL
	}
}
