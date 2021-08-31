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
 * @Title("[NO TESTCASEID]: Show Password Checkbox on Customer Login Form")
 * @Description("Check Show Password Functionality on Customer Login Form<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/StorefrontLoginFormShowPasswordTest.xml<br>")
 * @group Customer
 */
class StorefrontLoginFormShowPasswordTestCest
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
	 * @Stories({"Customer Login"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontLoginFormShowPasswordTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToSignInPage] StorefrontOpenCustomerLoginPageActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageGoToSignInPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToSignInPage
		$I->comment("Exiting Action Group [goToSignInPage] StorefrontOpenCustomerLoginPageActionGroup");
		$I->comment("Entering Action Group [fillLoginFormWithCustomerData] StorefrontFillCustomerLoginFormWithWrongPasswordActionGroup");
		$I->fillField("#email", $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: fillEmailFillLoginFormWithCustomerData
		$I->fillField("#pass", $I->retrieveEntityField('customer', 'password', 'test') . "_INCORRECT"); // stepKey: fillPasswordFillLoginFormWithCustomerData
		$I->comment("Exiting Action Group [fillLoginFormWithCustomerData] StorefrontFillCustomerLoginFormWithWrongPasswordActionGroup");
		$I->comment("Entering Action Group [clickShowPasswordCheckbox] StorefrontLoginFormClickShowPasswordActionGroup");
		$I->click("#show-password"); // stepKey: clickShowPasswordCheckboxClickShowPasswordCheckbox
		$I->comment("Exiting Action Group [clickShowPasswordCheckbox] StorefrontLoginFormClickShowPasswordActionGroup");
		$I->comment("Entering Action Group [AssertPasswordField] AssertLoginFormPasswordFieldActionGroup");
		$I->assertElementContainsAttribute("#pass", "type", "text"); // stepKey: assertPasswordFieldTypeAssertPasswordField
		$I->comment("Exiting Action Group [AssertPasswordField] AssertLoginFormPasswordFieldActionGroup");
	}
}
