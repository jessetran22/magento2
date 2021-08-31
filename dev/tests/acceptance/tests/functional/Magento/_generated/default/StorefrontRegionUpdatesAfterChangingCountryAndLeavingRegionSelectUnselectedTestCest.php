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
 * @Title("https://github.com/magento/magento2/issues/23460: Region updates after changing country")
 * @Description("Region dupdates after changing country and leaving region select unselected<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontRegionUpdatesAfterChangingCountryAndLeavingRegionSelectUnselectedTest.xml<br>")
 * @TestCaseId("https://github.com/magento/magento2/issues/23460")
 * @group checkout
 */
class StorefrontRegionUpdatesAfterChangingCountryAndLeavingRegionSelectUnselectedTestCest
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
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
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
	 * @Features({"Checkout"})
	 * @Stories({"Region updates after changing country"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontRegionUpdatesAfterChangingCountryAndLeavingRegionSelectUnselectedTest(AcceptanceTester $I)
	{
		$I->comment("Login to storefront from customer");
		$I->comment("Entering Action Group [loginCustomer] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginCustomer
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginCustomer
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginCustomer
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailLoginCustomer
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordLoginCustomer
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginCustomer
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginCustomer
		$I->comment("Exiting Action Group [loginCustomer] LoginToStorefrontActionGroup");
		$I->comment("Entering Action Group [goToMyAccountPage] StorefrontOpenMyAccountPageActionGroup");
		$I->amOnPage("/customer/account/"); // stepKey: goToMyAccountPageGoToMyAccountPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToMyAccountPage
		$I->comment("Exiting Action Group [goToMyAccountPage] StorefrontOpenMyAccountPageActionGroup");
		$I->comment("Entering Action Group [goToAddressBookPage] StorefrontCustomerGoToSidebarMenu");
		$I->click("//div[@id='block-collapsible-nav']//a[text()='Address Book']"); // stepKey: goToAddressBookGoToAddressBookPage
		$I->waitForPageLoad(60); // stepKey: goToAddressBookGoToAddressBookPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToAddressBookPage
		$I->comment("Exiting Action Group [goToAddressBookPage] StorefrontCustomerGoToSidebarMenu");
		$I->comment("Entering Action Group [clickEditAddress] StoreFrontClickEditDefaultShippingAddressActionGroup");
		$I->click("//div[@class='box-actions']//span[text()='Change Shipping Address']"); // stepKey: ClickEditDefaultShippingAddressClickEditAddress
		$I->waitForPageLoad(30); // stepKey: ClickEditDefaultShippingAddressClickEditAddressWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontSignInPageLoadClickEditAddress
		$I->comment("Exiting Action Group [clickEditAddress] StoreFrontClickEditDefaultShippingAddressActionGroup");
		$I->selectOption("//form[@class='form-address-edit']//select[contains(@name, 'country_id')]", "France"); // stepKey: selectCountry
		$I->comment("Entering Action Group [saveAddress] AdminSaveCustomerAddressActionGroup");
		$I->click("//button[@title='Save Address']"); // stepKey: saveCustomerAddressSaveAddress
		$I->waitForPageLoad(30); // stepKey: saveCustomerAddressSaveAddressWaitForPageLoad
		$I->see("You saved the address.", "div.message-success.success.message"); // stepKey: seeSuccessMessageSaveAddress
		$I->comment("Exiting Action Group [saveAddress] AdminSaveCustomerAddressActionGroup");
		$I->see("France", ".box-address-shipping"); // stepKey: seeAssertCustomerDefaultShippingAddressCountry
	}
}
