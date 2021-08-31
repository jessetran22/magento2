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
 * @Title("MC-15541: Verify Secure URLs For Storefront Paypal Pages")
 * @Description("Verify that the Secure URL configuration applies to the Paypal pages on the Storefront<h3>Test files</h3>app/code/Magento/Paypal/Test/Mftf/Test/StorefrontVerifySecureURLRedirectPaypalTest.xml<br>")
 * @TestCaseId("MC-15541")
 * @group paypal
 * @group configuration
 * @group secure_storefront_url
 */
class StorefrontVerifySecureURLRedirectPaypalTestCest
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
		$I->comment("Entering Action Group [flushCache] CliCacheFlushActionGroup");
		$flushSpecifiedCacheFlushCache = $I->magentoCLI("cache:flush", 60, ""); // stepKey: flushSpecifiedCacheFlushCache
		$I->comment($flushSpecifiedCacheFlushCache);
		$I->comment("Exiting Action Group [flushCache] CliCacheFlushActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$dontUseSecureURLsOnStorefront = $I->magentoCLI("config:set web/secure/use_in_frontend 0", 60); // stepKey: dontUseSecureURLsOnStorefront
		$I->comment($dontUseSecureURLsOnStorefront);
		$I->comment("Entering Action Group [flushCache] CliCacheFlushActionGroup");
		$flushSpecifiedCacheFlushCache = $I->magentoCLI("cache:flush", 60, ""); // stepKey: flushSpecifiedCacheFlushCache
		$I->comment($flushSpecifiedCacheFlushCache);
		$I->comment("Exiting Action Group [flushCache] CliCacheFlushActionGroup");
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
	 * @Features({"Paypal"})
	 * @Stories({"Storefront Secure URLs"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontVerifySecureURLRedirectPaypalTest(AcceptanceTester $I)
	{
		$hostname = $I->executeJS("return window.location.host"); // stepKey: hostname
		$I->amOnUrl("http://{$hostname}/paypal/billing"); // stepKey: goToUnsecurePaypalBillingURL
		$I->seeCurrentUrlEquals("https://{$hostname}/paypal/billing"); // stepKey: seeSecurePaypalBillingURL
		$I->amOnUrl("http://{$hostname}/paypal/billing_agreement"); // stepKey: goToUnsecurePaypalBillingAgreementURL
		$I->seeCurrentUrlEquals("https://{$hostname}/paypal/billing_agreement"); // stepKey: seeSecurePaypalBillingAgreementURL
		$I->amOnUrl("http://{$hostname}/paypal/bml"); // stepKey: goToUnsecurePaypalBmlURL
		$I->seeCurrentUrlEquals("https://{$hostname}/paypal/bml"); // stepKey: seeSecurePaypalBmlURL
		$I->amOnUrl("http://{$hostname}/paypal/hostedpro"); // stepKey: goToUnsecurePaypalHostedProURL
		$I->seeCurrentUrlEquals("https://{$hostname}/paypal/hostedpro"); // stepKey: seeSecurePaypalHostedProURL
		$I->amOnUrl("http://{$hostname}/paypal/ipn"); // stepKey: goToUnsecurePaypalIpnURL
		$I->seeCurrentUrlEquals("https://{$hostname}/paypal/ipn"); // stepKey: seeSecurePaypalIpnURL
		$I->amOnUrl("http://{$hostname}/paypal/payflow"); // stepKey: goToUnsecurePaypalPayflowUL
		$I->seeCurrentUrlEquals("https://{$hostname}/paypal/payflow"); // stepKey: seeSecurePaypalPayflowURL
		$I->amOnUrl("http://{$hostname}/paypal/payflowadvanced"); // stepKey: goToUnsecurePaypalPayflowAdvancedURL
		$I->seeCurrentUrlEquals("https://{$hostname}/paypal/payflowadvanced"); // stepKey: seeSecurePaypalPayflowAdvancedURL
		$I->amOnUrl("http://{$hostname}/paypal/payflowbml"); // stepKey: goToUnsecurePaypalPayflowBmlURL
		$I->seeCurrentUrlEquals("https://{$hostname}/paypal/payflowbml"); // stepKey: seeSecurePaypalPayflowBmlURL
		$I->amOnUrl("http://{$hostname}/paypal/payflowexpress"); // stepKey: goToUnsecurePaypalPayflowExpressURL
		$I->seeCurrentUrlEquals("https://{$hostname}/paypal/payflowexpress"); // stepKey: seeSecurePaypalPayflowExpressURL
		$I->amOnUrl("http://{$hostname}/paypal/transparent"); // stepKey: goToUnsecurePaypalTransparentURL
		$I->seeCurrentUrlEquals("https://{$hostname}/paypal/transparent"); // stepKey: seeSecurePaypalTransparentURL
		$I->amOnUrl("http://{$hostname}/paypal/express"); // stepKey: goToUnsecurePaypalExpressURL
		$I->seeCurrentUrlEquals("https://{$hostname}/paypal/express"); // stepKey: seeSecurePaypalExpressURL
	}
}
