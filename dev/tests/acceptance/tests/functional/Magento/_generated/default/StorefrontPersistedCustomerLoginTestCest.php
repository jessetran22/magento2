<?php
namespace Magento\AcceptanceTest\_default\Backend;

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
 * @Title("MAGETWO-72103: Persisted customer should be able to login from storefront")
 * @Description("Persisted customer should be able to login from storefront<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/StorefrontPersistedCustomerLoginTest.xml<br>")
 * @TestCaseId("MAGETWO-72103")
 * @group customer
 */
class StorefrontPersistedCustomerLoginTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("customer", "hook", "Simple_US_Customer", [], []); // stepKey: customer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
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
	 * @Features({"Customer"})
	 * @Stories({"Login"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontPersistedCustomerLoginTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToSignInPage] StorefrontOpenCustomerLoginPageActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageGoToSignInPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToSignInPage
		$I->comment("Exiting Action Group [goToSignInPage] StorefrontOpenCustomerLoginPageActionGroup");
		$I->comment("Entering Action Group [fillLoginFormWithCorrectCredentials] StorefrontFillCustomerLoginFormActionGroup");
		$I->fillField("#email", $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: fillEmailFillLoginFormWithCorrectCredentials
		$I->fillField("#pass", $I->retrieveEntityField('customer', 'password', 'test')); // stepKey: fillPasswordFillLoginFormWithCorrectCredentials
		$I->comment("Exiting Action Group [fillLoginFormWithCorrectCredentials] StorefrontFillCustomerLoginFormActionGroup");
		$I->comment("Entering Action Group [clickSignInAccountButton] StorefrontClickSignOnCustomerLoginFormActionGroup");
		$I->click("#send2"); // stepKey: clickSignInButtonClickSignInAccountButton
		$I->waitForPageLoad(30); // stepKey: clickSignInButtonClickSignInAccountButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerSignInClickSignInAccountButton
		$I->comment("Exiting Action Group [clickSignInAccountButton] StorefrontClickSignOnCustomerLoginFormActionGroup");
		$I->see($I->retrieveEntityField('customer', 'firstname', 'test'), ".box.box-information .box-content"); // stepKey: seeFirstName
		$I->see($I->retrieveEntityField('customer', 'lastname', 'test'), ".box.box-information .box-content"); // stepKey: seeLastName
		$I->see($I->retrieveEntityField('customer', 'email', 'test'), ".box.box-information .box-content"); // stepKey: seeEmail
	}
}
