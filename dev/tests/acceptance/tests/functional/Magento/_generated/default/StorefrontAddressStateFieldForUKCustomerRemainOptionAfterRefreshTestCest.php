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
 * @Title("MC-25694: Address State Field For UK Customers Remain Option even After Browser Refresh")
 * @Description("Address State Field For UK Customers Remain Option even After Browser Refresh<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontAddressStateFieldForUKCustomerRemainOptionAfterRefreshTest.xml<br>")
 * @TestCaseId("MC-25694")
 * @group checkout
 */
class StorefrontAddressStateFieldForUKCustomerRemainOptionAfterRefreshTestCest
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
		$I->createEntity("createSimpleProduct", "hook", "simpleProductWithoutCategory", [], []); // stepKey: createSimpleProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteProduct
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
	 * @Stories({"Guest checkout"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontAddressStateFieldForUKCustomerRemainOptionAfterRefreshTest(AcceptanceTester $I)
	{
		$I->comment("Step 1 Add simple product to the cart");
		$I->comment("Entering Action Group [addProductToCart] StorefrontAddSimpleProductToShoppingCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForProductPageOpenAddProductToCart
		$I->fillField("#qty", "1"); // stepKey: fillQtyAddProductToCart
		$I->click("button#product-addtocart-button"); // stepKey: clickAddToCartAddProductToCart
		$I->waitForElementVisible(".messages .message-success", 30); // stepKey: waitForSuccessMessageAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] StorefrontAddSimpleProductToShoppingCartActionGroup");
		$I->comment("Step 2 Proceed to Checkout and be on Shipping page");
		$I->comment("Entering Action Group [goToCheckout] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityGoToCheckout
		$I->wait(5); // stepKey: waitMinicartRenderingGoToCheckout
		$I->click("a.showcart"); // stepKey: clickCartGoToCheckout
		$I->waitForPageLoad(60); // stepKey: clickCartGoToCheckoutWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutGoToCheckout
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGoToCheckoutWaitForPageLoad
		$I->comment("Exiting Action Group [goToCheckout] GoToCheckoutFromMinicartActionGroup");
		$I->comment("Step 3 Select Country as United Kingdom and Refresh the page");
		$I->selectOption("select[name=country_id]", "GB"); // stepKey: selectCounty
		$I->waitForPageLoad(30); // stepKey: waitFormToReload
		$I->comment("Entering Action Group [refreshPage] ReloadPageActionGroup");
		$I->reloadPage(); // stepKey: reloadPageRefreshPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadRefreshPage
		$I->comment("Exiting Action Group [refreshPage] ReloadPageActionGroup");
		$I->comment("Assert Selected Country is United States");
		$I->seeOptionIsSelected("select[name=country_id]", "United States"); // stepKey: selectedCountryIsUnitedStates
		$I->comment("Step 4 Select Country as United Kingdom, select address street and Refresh the page");
		$I->selectOption("select[name=country_id]", "GB"); // stepKey: selectUnitedKingdomCounty
		$I->waitForPageLoad(30); // stepKey: waitFormToReloadAfterSelectCountry
		$I->fillField("input[name='street[0]']", "7700 xyz street"); // stepKey: enterAddressStreet
		$I->comment("Entering Action Group [refreshPageAfterAddressIsAdded] ReloadPageActionGroup");
		$I->reloadPage(); // stepKey: reloadPageRefreshPageAfterAddressIsAdded
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadRefreshPageAfterAddressIsAdded
		$I->comment("Exiting Action Group [refreshPageAfterAddressIsAdded] ReloadPageActionGroup");
		$I->comment("Assert Entered details should be retained and State/Province field should be displayed as an optional field (without * )");
		$I->seeOptionIsSelected("select[name=country_id]", "United Kingdom"); // stepKey: selectedCountryIsUnitedKingdom
		$I->seeInField("input[name='street[0]']", "7700 xyz street"); // stepKey: seeAddressStreetUnitedKingdom
		$I->dontSeeElement("//div[@id='shipping-new-address-form']//div[contains(@class, 'field _required') and contains(@name, 'shippingAddress.region_id')]"); // stepKey: assertStateProvinceIsNotRequired
		$I->waitForPageLoad(30); // stepKey: assertStateProvinceIsNotRequiredWaitForPageLoad
	}
}
