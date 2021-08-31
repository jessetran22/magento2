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
 * @Title("[NO TESTCASEID]: Not visible individually product in mini-shopping cart.")
 * @Description("To be sure that product in mini-shopping cart remains visible after admin makes it not visible individually<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/CheckNotVisibleProductInMinicartTest.xml<br>")
 * @group checkout
 */
class CheckNotVisibleProductInMinicartTestCest
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
	 * @Features({"Checkout"})
	 * @Stories({"MAGETWO-96422: Hidden Products are absent in Storefront Mini-Cart"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function CheckNotVisibleProductInMinicartTest(AcceptanceTester $I)
	{
		$I->comment("Create simple product1 and simple product2");
		$I->createEntity("createSimpleProduct1", "test", "SimpleTwo", [], []); // stepKey: createSimpleProduct1
		$I->createEntity("createSimpleProduct2", "test", "SimpleTwo", [], []); // stepKey: createSimpleProduct2
		$I->comment("Go to simple product1 page");
		$I->amOnPage($I->retrieveEntityField('createSimpleProduct1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToSimpleProductPage1
		$I->waitForPageLoad(30); // stepKey: waitForCatalogPageLoad
		$I->comment("Add simple product1 to Shopping Cart");
		$I->comment("Entering Action Group [addToCartFromStorefrontProductPage1] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProductPage1
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProductPage1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartFromStorefrontProductPage1
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddToCartFromStorefrontProductPage1
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddToCartFromStorefrontProductPage1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartFromStorefrontProductPage1
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProductPage1
		$I->see("You added " . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartFromStorefrontProductPage1
		$I->comment("Exiting Action Group [addToCartFromStorefrontProductPage1] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Check simple product 1 in minicart");
		$I->comment("Check simple product1 in minicart");
		$I->comment("Entering Action Group [assertProduct1NameInMiniCart] AssertOneProductNameInMiniCartActionGroup");
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartAssertProduct1NameInMiniCart
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleAssertProduct1NameInMiniCart
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleAssertProduct1NameInMiniCartWaitForPageLoad
		$I->see($I->retrieveEntityField('createSimpleProduct1', 'name', 'test'), ".minicart-items"); // stepKey: seeInMiniCartAssertProduct1NameInMiniCart
		$I->comment("Exiting Action Group [assertProduct1NameInMiniCart] AssertOneProductNameInMiniCartActionGroup");
		$I->comment("Make simple product1 not visible individually");
		$I->updateEntity("createSimpleProduct1", "test", "SetProductVisibilityHidden",["createSimpleProduct1"]); // stepKey: updateSimpleProduct1
		$I->comment("Go to simple product2 page");
		$I->amOnPage($I->retrieveEntityField('createSimpleProduct2', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToSimpleProductPage2
		$I->waitForPageLoad(30); // stepKey: waitForCatalogPageLoad2
		$I->comment("Add simple product2 to Shopping Cart for updating cart items");
		$I->comment("Entering Action Group [addToCartFromStorefrontProductPage2] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProductPage2
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProductPage2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartFromStorefrontProductPage2
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddToCartFromStorefrontProductPage2
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddToCartFromStorefrontProductPage2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartFromStorefrontProductPage2
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProductPage2
		$I->see("You added " . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartFromStorefrontProductPage2
		$I->comment("Exiting Action Group [addToCartFromStorefrontProductPage2] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Check hidden simple product 2 in minicart");
		$I->comment("Check hidden simple product 1 in minicart");
		$I->comment("Check simple product1 in minicart");
		$I->comment("Entering Action Group [assertHiddenProduct1NameInMiniCart] AssertOneProductNameInMiniCartActionGroup");
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartAssertHiddenProduct1NameInMiniCart
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleAssertHiddenProduct1NameInMiniCart
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleAssertHiddenProduct1NameInMiniCartWaitForPageLoad
		$I->see($I->retrieveEntityField('createSimpleProduct1', 'name', 'test'), ".minicart-items"); // stepKey: seeInMiniCartAssertHiddenProduct1NameInMiniCart
		$I->comment("Exiting Action Group [assertHiddenProduct1NameInMiniCart] AssertOneProductNameInMiniCartActionGroup");
		$I->comment("Check simple product2 in minicart");
		$I->comment("Entering Action Group [assertProduct2NameInMiniCart] AssertOneProductNameInMiniCartActionGroup");
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartAssertProduct2NameInMiniCart
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleAssertProduct2NameInMiniCart
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleAssertProduct2NameInMiniCartWaitForPageLoad
		$I->see($I->retrieveEntityField('createSimpleProduct2', 'name', 'test'), ".minicart-items"); // stepKey: seeInMiniCartAssertProduct2NameInMiniCart
		$I->comment("Exiting Action Group [assertProduct2NameInMiniCart] AssertOneProductNameInMiniCartActionGroup");
		$I->comment("Delete simple product1 and simple product2");
		$I->deleteEntity("createSimpleProduct1", "test"); // stepKey: deleteProduct1
		$I->deleteEntity("createSimpleProduct2", "test"); // stepKey: deleteProduct2
	}
}
