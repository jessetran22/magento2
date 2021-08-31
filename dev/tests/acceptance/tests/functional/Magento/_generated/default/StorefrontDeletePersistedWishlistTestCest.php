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
 * @Title("MC-4110: Customer should be able to delete a persistent wishlist")
 * @Description("Customer should be able to delete a persistent wishlist<h3>Test files</h3>app/code/Magento/Wishlist/Test/Mftf/Test/StorefrontDeletePersistedWishlistTest.xml<br>")
 * @group wishlist
 * @TestCaseId("MC-4110")
 */
class StorefrontDeletePersistedWishlistTestCest
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
        $this->helperContainer->create("\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
        $this->helperContainer->create("Magento\Tax\Test\Mftf\Helper\TaxHelpers");
        $this->helperContainer->create("Magento\Backend\Test\Mftf\Helper\CurlHelpers");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("category", "hook", "SimpleSubCategory", [], []); // stepKey: category
		$I->createEntity("product", "hook", "SimpleProduct", ["category"], []); // stepKey: product
		$I->createEntity("customer", "hook", "Simple_US_Customer", [], []); // stepKey: customer
		$I->createEntity("wishlist", "hook", "Wishlist", ["customer", "product"], []); // stepKey: wishlist
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("category", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("product", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("customer", "hook"); // stepKey: deleteCustomer
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
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
	 * @Stories({"Delete a persist wishlist for a customer"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontDeletePersistedWishlistTest(AcceptanceTester $I)
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
		$I->amOnPage("/wishlist/"); // stepKey: amOnWishlist
		$I->waitForPageLoad(30); // stepKey: waitForWishlist
		$I->see($I->retrieveEntityField('product', 'price', 'test'), "//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('product', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: seeWishlist
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('product', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: mouseOver
		$I->waitForElementVisible("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('product', 'name', 'test') . "')]]//a[@data-role='remove']", 30); // stepKey: waitForRemoveButton
		$I->waitForPageLoad(30); // stepKey: waitForRemoveButtonWaitForPageLoad
		$I->click("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('product', 'name', 'test') . "')]]//a[@data-role='remove']"); // stepKey: clickRemove
		$I->waitForPageLoad(30); // stepKey: clickRemoveWaitForPageLoad
		$I->see("You have no items in your wish list", ".message.info.empty>span"); // stepKey: seeEmptyWishlist
	}
}
