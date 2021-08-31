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
 * @Title("MC-14691: Delete virtual product from shopping cart test")
 * @Description("Delete virtual product from shopping cart<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/DeleteVirtualProductFromShoppingCartTest.xml<br>")
 * @TestCaseId("MC-14691")
 * @group checkout
 * @group mtf_migrated
 */
class DeleteVirtualProductFromShoppingCartTestCest
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
		$I->comment("Create virtual product");
		$createVirtualProductFields['price'] = "50";
		$I->createEntity("createVirtualProduct", "hook", "VirtualProduct", [], $createVirtualProductFields); // stepKey: createVirtualProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete virtual product");
		$I->deleteEntity("createVirtualProduct", "hook"); // stepKey: deleteVirtualProduct
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
	public function DeleteVirtualProductFromShoppingCartTest(AcceptanceTester $I)
	{
		$I->comment("Add virtual product to the cart");
		$I->amOnPage("/" . $I->retrieveEntityField('createVirtualProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad
		$I->comment("Entering Action Group [addToCartVirtualProductFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartVirtualProductFromStorefrontProductPage
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartVirtualProductFromStorefrontProductPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartVirtualProductFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddToCartVirtualProductFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddToCartVirtualProductFromStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartVirtualProductFromStorefrontProductPage
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartVirtualProductFromStorefrontProductPage
		$I->see("You added " . $I->retrieveEntityField('createVirtualProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartVirtualProductFromStorefrontProductPage
		$I->comment("Exiting Action Group [addToCartVirtualProductFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Remove product from cart");
		$I->comment("Entering Action Group [goToCart] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageGoToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToCart
		$I->comment("Exiting Action Group [goToCart] StorefrontCartPageOpenActionGroup");
		$I->comment("Entering Action Group [deleteProduct] DeleteProductFromShoppingCartActionGroup");
		$I->click("//*[contains(text(), '" . $I->retrieveEntityField('createVirtualProduct', 'name', 'test') . "')]/ancestor::tbody//a[@class='action action-delete']"); // stepKey: deleteProductFromCheckoutCartDeleteProduct
		$I->waitForPageLoad(30); // stepKey: deleteProductFromCheckoutCartDeleteProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadDeleteProduct
		$I->see("You have no items in your shopping cart."); // stepKey: seeNoItemsInShoppingCartDeleteProduct
		$I->comment("Exiting Action Group [deleteProduct] DeleteProductFromShoppingCartActionGroup");
	}
}
