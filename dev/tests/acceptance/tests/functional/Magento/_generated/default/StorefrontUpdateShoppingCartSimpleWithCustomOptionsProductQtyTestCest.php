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
 * @Title("MC-14732: Check updating shopping cart while updating qty of items with custom options")
 * @Description("Check updating shopping cart while updating qty of items with custom options<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontUpdateShoppingCartSimpleWithCustomOptionsProductQtyTest.xml<br>")
 * @TestCaseId("MC-14732")
 * @group shoppingCart
 * @group mtf_migrated
 */
class StorefrontUpdateShoppingCartSimpleWithCustomOptionsProductQtyTestCest
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
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "ApiSimpleProductWithCustomPrice", ["createCategory"], []); // stepKey: createProduct
		$I->comment("Add two custom options to the product: field and textarea");
		$I->updateEntity("createProduct", "hook", "ProductWithTextFieldAndAreaOptions",[]); // stepKey: updateProductWithOption
		$I->comment("Go to the product page, fill the custom options values and add the product to the shopping cart");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'hook') . ".html"); // stepKey: amOnProductPage
		$I->waitForPageLoad(30); // stepKey: waitForCatalogPageLoad
		$I->fillField("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'OptionField')]/../div[@class='control']//input[@type='text']", "OptionField"); // stepKey: fillProductOptionInputField
		$I->fillField("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'OptionArea')]/../div[@class='control']//textarea", "OptionArea"); // stepKey: fillProductOptionInputArea
		$I->comment("Entering Action Group [addToCartFromStorefrontProductPage] StorefrontAddToCartCustomOptionsProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProductPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartFromStorefrontProductPage
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProductPage
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'hook') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartFromStorefrontProductPage
		$I->comment("Exiting Action Group [addToCartFromStorefrontProductPage] StorefrontAddToCartCustomOptionsProductPageActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
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
	 * @Stories({"Shopping cart"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontUpdateShoppingCartSimpleWithCustomOptionsProductQtyTest(AcceptanceTester $I)
	{
		$I->comment("Go to the shopping cart");
		$I->comment("Entering Action Group [amOnPageShoppingCart] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageAmOnPageShoppingCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedAmOnPageShoppingCart
		$I->comment("Exiting Action Group [amOnPageShoppingCart] StorefrontCartPageOpenActionGroup");
		$I->comment("Change the product QTY");
		$I->fillField("//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "'][1]//td[contains(@class, 'qty')]//input[contains(@class, 'qty')]", "11"); // stepKey: changeCartQty
		$I->click("#form-validate button[type='submit'].update"); // stepKey: updateShoppingCart
		$I->waitForPageLoad(30); // stepKey: updateShoppingCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitShoppingCartUpdated
		$I->comment("The price and QTY values should be updated for the product");
		$grabProductQtyInCart = $I->grabValueFrom("//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "'][1]//td[contains(@class, 'qty')]//input[contains(@class, 'qty')]"); // stepKey: grabProductQtyInCart
		$I->see("$1,320.00", "//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "'][1]//td[contains(@class, 'subtotal')]//span[@class='price']"); // stepKey: assertProductPrice
		$I->assertEquals("11", $grabProductQtyInCart); // stepKey: assertProductQtyInCart
		$I->see("$1,320.00", "//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']"); // stepKey: assertSubtotal
		$I->comment("Minicart product price and subtotal should be updated");
		$I->comment("Entering Action Group [openMinicart] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->scrollTo("a.showcart"); // stepKey: scrollToMiniCartOpenMinicart
		$I->waitForPageLoad(60); // stepKey: scrollToMiniCartOpenMinicartWaitForPageLoad
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartOpenMinicart
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleOpenMinicart
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleOpenMinicartWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: viewAndEditCartOpenMinicart
		$I->waitForPageLoad(30); // stepKey: viewAndEditCartOpenMinicartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadOpenMinicart
		$I->seeInCurrentUrl("checkout/cart"); // stepKey: seeInCurrentUrlOpenMinicart
		$I->comment("Exiting Action Group [openMinicart] ClickViewAndEditCartFromMiniCartActionGroup");
		$grabProductQtyInMinicart = $I->grabValueFrom("//a[text()='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "']/../..//input[contains(@class,'cart-item-qty')]"); // stepKey: grabProductQtyInMinicart
		$I->assertEquals("11", $grabProductQtyInMinicart); // stepKey: assertProductQtyInMinicart
		$I->see("$1,320.00", "//tr[@class='totals sub']//td[@class='amount']/span"); // stepKey: assertMinicartSubtotal
	}
}
