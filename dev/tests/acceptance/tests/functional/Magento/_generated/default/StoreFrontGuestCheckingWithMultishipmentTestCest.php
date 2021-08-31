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
 * @Title("MC-41679: Guest can register through multi shipment checkout")
 * @Description("Check that guest can register through multi shipment checkout<h3>Test files</h3>app/code/Magento/Multishipping/Test/Mftf/Test/StoreFrontGuestCheckingWithMultishipmentTest.xml<br>")
 * @TestCaseId("MC-41679")
 * @group multishipping
 */
class StoreFrontGuestCheckingWithMultishipmentTestCest
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
		$I->createEntity("product1", "hook", "SimpleProduct2", [], []); // stepKey: product1
		$I->createEntity("product2", "hook", "SimpleProduct2", [], []); // stepKey: product2
		$I->createEntity("enableFlatRateShipping", "hook", "FlatRateShippingMethodConfig", [], []); // stepKey: enableFlatRateShipping
		$I->comment("Entering Action Group [enableCheckMoneyOrderPaymentMethod] CliEnableCheckMoneyOrderPaymentMethodActionGroup");
		$enableCheckMoneyOrderPaymentMethodEnableCheckMoneyOrderPaymentMethod = $I->magentoCLI("config:set payment/checkmo/active 1", 60); // stepKey: enableCheckMoneyOrderPaymentMethodEnableCheckMoneyOrderPaymentMethod
		$I->comment($enableCheckMoneyOrderPaymentMethodEnableCheckMoneyOrderPaymentMethod);
		$I->comment("Exiting Action Group [enableCheckMoneyOrderPaymentMethod] CliEnableCheckMoneyOrderPaymentMethodActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("product1", "hook"); // stepKey: deleteProduct1
		$I->deleteEntity("product2", "hook"); // stepKey: deleteProduct2
		$I->createEntity("disableFreeShipping", "hook", "FreeShippinMethodDefault", [], []); // stepKey: disableFreeShipping
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
	 * @Features({"Multishipping"})
	 * @Stories({"Multiple Shipping"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StoreFrontGuestCheckingWithMultishipmentTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToProduct1Page] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('product1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageGoToProduct1Page
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedGoToProduct1Page
		$I->comment("Exiting Action Group [goToProduct1Page] StorefrontOpenProductPageActionGroup");
		$I->comment("Entering Action Group [addToCartFromStorefrontProduct1] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProduct1
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProduct1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartFromStorefrontProduct1
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddToCartFromStorefrontProduct1
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddToCartFromStorefrontProduct1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartFromStorefrontProduct1
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProduct1
		$I->see("You added " . $I->retrieveEntityField('product1', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartFromStorefrontProduct1
		$I->comment("Exiting Action Group [addToCartFromStorefrontProduct1] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Entering Action Group [goToProduct2Page] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('product2', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageGoToProduct2Page
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedGoToProduct2Page
		$I->comment("Exiting Action Group [goToProduct2Page] StorefrontOpenProductPageActionGroup");
		$I->comment("Entering Action Group [addToCartFromStorefrontProduct2] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProduct2
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProduct2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartFromStorefrontProduct2
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddToCartFromStorefrontProduct2
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddToCartFromStorefrontProduct2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartFromStorefrontProduct2
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProduct2
		$I->see("You added " . $I->retrieveEntityField('product2', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartFromStorefrontProduct2
		$I->comment("Exiting Action Group [addToCartFromStorefrontProduct2] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Entering Action Group [openCart] StorefrontOpenCartFromMinicartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfThePageOpenCart
		$I->waitForElement("a.showcart", 30); // stepKey: waitForShowMinicartOpenCart
		$I->waitForPageLoad(60); // stepKey: waitForShowMinicartOpenCartWaitForPageLoad
		$I->waitForElement(".action.viewcart", 30); // stepKey: waitForCartLinkOpenCart
		$I->waitForPageLoad(30); // stepKey: waitForCartLinkOpenCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickShowMinicartOpenCart
		$I->waitForPageLoad(60); // stepKey: clickShowMinicartOpenCartWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: clickCartOpenCart
		$I->waitForPageLoad(30); // stepKey: clickCartOpenCartWaitForPageLoad
		$I->comment("Exiting Action Group [openCart] StorefrontOpenCartFromMinicartActionGroup");
		$I->click("//span[text()='Check Out with Multiple Addresses']"); // stepKey: proceedMultishipping
		$I->click("//div[contains(@class,'actions-toolbar')]//a[contains(.,'Create an Account')]"); // stepKey: clickCreateAccount
		$I->waitForPageLoad(30); // stepKey: clickCreateAccountWaitForPageLoad
		$I->seeElement("select[name=region_id]"); // stepKey: seeRegionSelector
	}
}
