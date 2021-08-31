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
 * @Title("MC-6141: Storefront check necessary logic to action class for cookie messages test")
 * @Description("Check necessary logic to action class for cookie messages<h3>Test files</h3>app/code/Magento/Security/Test/Mftf/Test/StorefrontCheckNecessaryLogicToActionClassForCookieMessagesTest.xml<br>")
 * @TestCaseId("MC-6141")
 * @group security
 * @group customer
 */
class StorefrontCheckNecessaryLogicToActionClassForCookieMessagesTestCest
{
    /**
     * @var \Magento\FunctionalTestingFramework\Helper\HelperContainer
     */
    private $helperContainer;

    /**
     * Special method which automatically creates the respective objects.
     */
    public function _inject(\Magento\FunctionalTestingFramework\Helper\HelperContainer $helperContainer)
    {
        $this->helperContainer = $helperContainer;
        $this->helperContainer->create("Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Create customer");
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete customer");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
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
	 * @Features({"Security"})
	 * @Stories({"Check necessary logic to action class for cookie messages"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCheckNecessaryLogicToActionClassForCookieMessagesTest(AcceptanceTester $I)
	{
		$I->comment("Login to application");
		$I->comment("Entering Action Group [loginToStorefrontAccount] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginToStorefrontAccount
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginToStorefrontAccount
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginToStorefrontAccount
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailLoginToStorefrontAccount
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordLoginToStorefrontAccount
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginToStorefrontAccount
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginToStorefrontAccountWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginToStorefrontAccount
		$I->comment("Exiting Action Group [loginToStorefrontAccount] LoginToStorefrontActionGroup");
		$I->comment("Open 'My Account' page and click 'Edit; link");
		$I->comment("Entering Action Group [goToMyAccountPage] StorefrontOpenMyAccountPageActionGroup");
		$I->amOnPage("/customer/account/"); // stepKey: goToMyAccountPageGoToMyAccountPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToMyAccountPage
		$I->comment("Exiting Action Group [goToMyAccountPage] StorefrontOpenMyAccountPageActionGroup");
		$I->click(".box-information .edit"); // stepKey: clickEditContactInformation
		$I->comment("Mark as checked 'Change email' check-box. Assert 2 labels under 'Change Email' block");
		$I->checkOption(".form-edit-account input[name='change_email']"); // stepKey: clickChangeEmailCheckbox
		$I->seeElement(".form-edit-account input[name='email']"); // stepKey: seeEmailField
		$I->seeElement("#current-password"); // stepKey: seeCurrentPasswordField
		$I->comment("Change email attribute 'type' from email to text and type script after email address. Click 'Save' button");
		$changeAttributeFromEmailToText = $I->executeJS("document.querySelector('#email').setAttribute('type', 'text');"); // stepKey: changeAttributeFromEmailToText
		$I->fillField(".form-edit-account input[name='email']", $I->retrieveEntityField('createCustomer', 'email', 'test') . "<script>alert('Hello')</script>"); // stepKey: fillEmailWithScript
		$I->click("#form-validate .action.save.primary"); // stepKey: clickSave
		$I->waitForPageLoad(30); // stepKey: clickSaveWaitForPageLoad
		$I->comment("Assert error messages for email and password fields");
		$I->dontSee("Please enter a valid email address.", "#email-error"); // stepKey: dontSeeEmailErrorMessage
		$I->see("This is a required field.", "#current-password-error"); // stepKey: seeErrorPasswordMessage
		$I->comment("Fill password and click 'Save' button");
		$I->fillField("#current-password", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillCurrentPassword
		$I->click("#form-validate .action.save.primary"); // stepKey: saveChanges
		$I->waitForPageLoad(30); // stepKey: saveChangesWaitForPageLoad
		$I->comment("Throw validation error message (server side validation) with escaped customer input");
		$I->see("\"Email\" is not a valid hostname. 'example.com<script>alert('Hello')</script>' looks like a DNS hostname but we cannot match it against the hostname schema for TLD 'com<script>alert('Hello')</script>'. 'example.com<script>alert('Hello')</script>' does not look like a valid local network name.", ".page.messages [role=alert]"); // stepKey: seeValidationErrorMessage
	}
}
