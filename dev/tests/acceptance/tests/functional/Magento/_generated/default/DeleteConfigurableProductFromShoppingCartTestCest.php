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
 * @Title("MC-14692: Delete configurable product from shopping cart test")
 * @Description("Delete configurable product from shopping cart<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/DeleteConfigurableProductFromShoppingCartTest.xml<br>")
 * @TestCaseId("MC-14692")
 * @group checkout
 * @group mtf_migrated
 */
class DeleteConfigurableProductFromShoppingCartTestCest
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
		$I->comment("Create category");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->comment("Create configurable product");
		$I->createEntity("createConfigProduct", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createConfigProduct
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createConfigProductAttributeOption", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createConfigProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->getEntity("getConfigAttributeOption", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 1); // stepKey: getConfigAttributeOption
		$I->createEntity("createConfigChildProduct", "hook", "ApiSimpleOne", ["createConfigProductAttribute", "getConfigAttributeOption", "createCategory"], []); // stepKey: createConfigChildProduct
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProductTwoOptions", ["createConfigProduct", "createConfigProductAttribute", "getConfigAttributeOption"], []); // stepKey: createConfigProductOption
		$I->createEntity("createConfigProductAddChild", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct"], []); // stepKey: createConfigProductAddChild
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete configurable product data");
		$I->deleteEntity("createConfigChildProduct", "hook"); // stepKey: deleteConfigChildProduct
		$I->deleteEntity("createConfigProduct", "hook"); // stepKey: deleteConfigProduct
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteConfigProductAttribute
		$I->comment("Delete category");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Reindex invalidated indices after product attribute has been created/deleted");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
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
	 * @Stories({"Delete Products from Shopping Cart"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function DeleteConfigurableProductFromShoppingCartTest(AcceptanceTester $I)
	{
		$I->comment("Add configurable product to the cart");
		$I->comment("Entering Action Group [addConfigurableProductToCart] StorefrontAddConfigurableProductToTheCartActionGroup");
		$I->amOnPage($I->retrieveEntityField('createConfigProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToStorefrontPageAddConfigurableProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForProductFrontPageToLoadAddConfigurableProductToCart
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'" . $I->retrieveEntityField('createConfigProductAttribute', 'default_value', 'test') . "')]/../div[@class='control']//select", $I->retrieveEntityField('getConfigAttributeOption', 'value', 'test')); // stepKey: selectOption1AddConfigurableProductToCart
		$I->fillField("input.input-text.qty", "1"); // stepKey: fillProductQuantityAddConfigurableProductToCart
		$I->waitForPageLoad(30); // stepKey: fillProductQuantityAddConfigurableProductToCartWaitForPageLoad
		$I->click("#product-addtocart-button"); // stepKey: clickOnAddToCartButtonAddConfigurableProductToCart
		$I->waitForPageLoad(60); // stepKey: clickOnAddToCartButtonAddConfigurableProductToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductToAddInCartAddConfigurableProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddConfigurableProductToCart
		$I->seeElement("div.message-success"); // stepKey: seeSuccessSaveMessageAddConfigurableProductToCart
		$I->waitForPageLoad(30); // stepKey: seeSuccessSaveMessageAddConfigurableProductToCartWaitForPageLoad
		$I->comment("Exiting Action Group [addConfigurableProductToCart] StorefrontAddConfigurableProductToTheCartActionGroup");
		$I->comment("Remove product from cart");
		$I->comment("Entering Action Group [goToCart] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageGoToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToCart
		$I->comment("Exiting Action Group [goToCart] StorefrontCartPageOpenActionGroup");
		$I->comment("Entering Action Group [deleteProduct] DeleteProductFromShoppingCartActionGroup");
		$I->click("//*[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]/ancestor::tbody//a[@class='action action-delete']"); // stepKey: deleteProductFromCheckoutCartDeleteProduct
		$I->waitForPageLoad(30); // stepKey: deleteProductFromCheckoutCartDeleteProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadDeleteProduct
		$I->see("You have no items in your shopping cart."); // stepKey: seeNoItemsInShoppingCartDeleteProduct
		$I->comment("Exiting Action Group [deleteProduct] DeleteProductFromShoppingCartActionGroup");
	}
}
